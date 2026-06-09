<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    private const LOCKED_STATUSES = ['paid', 'shipped', 'delivered', 'cancelled'];

    public function store(Request $request)
    {
        $data = $this->validateOrderData($request);

        $checkoutSingle = session('checkout_single', null);
        $cart = $checkoutSingle ? [$checkoutSingle] : session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->withErrors(['cart' => 'Giỏ hàng trống']);
        }

        $subtotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['qty']);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'fullname' => $data['fullname'],
                'email' => $data['email'],
                'address' => $data['address'],
                'payment_method' => $data['payment_method'] ?? null,
                'subtotal' => $subtotal,
                'shipping' => 0,
                'total' => $subtotal,
                'status' => 'processing',
            ]);

            foreach ($cart as $c) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $c['id'] ?? null,
                    'name' => $c['name'],
                    'image' => $c['image'] ?? null,
                    'price' => $c['price'],
                    'qty' => $c['qty'],
                    'size' => $c['size'] ?? null,
                    'total' => $c['price'] * $c['qty'],
                ]);
            }

            DB::commit();
            // clear only checkout_single if used, otherwise clear cart
            if ($checkoutSingle) {
                $request->session()->forget('checkout_single');
            } else {
                $request->session()->forget('cart');
            }

            return redirect('/index')->with('status','Đặt hàng thành công! Mã đơn: '.$order->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['order' => 'Không thể tạo đơn hàng: '.$e->getMessage()]);
        }
    }

    // Show order detail to owner
    public function show($id)
    {
        $order = $this->findUserOrder($id, ['items']);
        if (! $order) {
            abort(404);
        }

        return view('user.order', ['order' => $order]);
    }

    // Edit order (only basic fields and only if status allows)
    public function edit($id)
    {
        $order = $this->findUserOrderOrFail($id, ['items']);
        if ($this->isLockedStatus($order->status)) {
            return redirect()->route('account.orders.show', $order->id)->with('error', 'Không thể chỉnh sửa đơn hàng ở trạng thái hiện tại');
        }

        return view('user.order_edit', ['order' => $order]);
    }

    // Update order basic info (fullname, email, address, payment_method)
    public function update(Request $request, $id)
    {
        $order = $this->findUserOrderOrFail($id);
        if ($this->isLockedStatus($order->status)) {
            return redirect()->route('account.orders.show', $order->id)->with('error', 'Không thể chỉnh sửa đơn hàng ở trạng thái hiện tại');
        }

        $data = $this->validateOrderData($request);

        $order->fill([
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'address' => $data['address'],
            'payment_method' => $data['payment_method'] ?? $order->payment_method,
        ]);
        $order->save();

        return redirect()->route('account.orders.show', $order->id)->with('status', 'Đã cập nhật đơn hàng');
    }

    // Update payment method only (quick action)
    public function updatePaymentMethod(Request $request, $id)
    {
        $order = $this->findUserOrderOrFail($id);
        if ($this->isLockedStatus($order->status)) {
            return redirect()->route('account.orders.show', $order->id)->with('error', 'Không thể thay đổi phương thức ở trạng thái hiện tại');
        }

        $data = $request->validate([
            'payment_method' => ['required', 'string'],
        ]);

        $order->payment_method = $data['payment_method'];
        $order->save();

        return redirect()->route('account.orders.show', $order->id)->with('status', 'Đã cập nhật phương thức thanh toán');
    }

    // Update order items (change qty / remove items) — allowed only while processing
    public function updateItems(Request $request, $id)
    {
        $order = $this->findUserOrderOrFail($id, ['items']);
        if ($order->status !== 'processing') {
            return redirect()->route('account.orders.show', $order->id)->with('error', 'Chỉ có thể chỉnh sửa sản phẩm khi đơn đang xử lý');
        }

        $items = $request->input('items', []);
        if (!is_array($items)) {
            return redirect()->back()->with('error', 'Dữ liệu sản phẩm không hợp lệ');
        }

        foreach ($items as $orderItemId => $values) {
            $oi = $order->items->where('id', $orderItemId)->first();
            if (! $oi) {
                continue;
            }

            // If remove flag set, delete
            if (!empty($values['remove']) || (isset($values['qty']) && intval($values['qty']) <= 0)) {
                $oi->delete();
                continue;
            }

            // Otherwise update quantity
            if (isset($values['qty'])) {
                $qty = max(1, intval($values['qty']));
                $oi->qty = $qty;
                $oi->total = $oi->price * $oi->qty;
                $oi->save();
            }
        }

        // Recalculate order totals
        $subtotal = $order->items()->sum('total');
        if ($subtotal <= 0) {
            // If no items left, cancel the order
            $order->status = 'cancelled';
            $order->subtotal = 0;
            $order->total = 0;
            $order->save();
            // After auto-cancel, go back to account page
            return redirect()->route('account')->with('status', 'Đã huỷ đơn do không còn sản phẩm');
        }

        $order->subtotal = $subtotal;
        $order->total = $subtotal + ($order->shipping ?? 0);
        $order->save();

        return redirect()->route('account.orders.show', $order->id)->with('status', 'Đã cập nhật sản phẩm trong đơn');
    }

    // Cancel order (only while processing)
    public function cancel(Request $request, $id)
    {
        $order = $this->findUserOrderOrFail($id);
        if ($order->status !== 'processing') {
            return redirect()->route('account.orders.show', $order->id)->with('error', 'Chỉ có thể huỷ đơn khi đang xử lý');
        }

        $order->status = 'cancelled';
        $order->save();

        // After cancelling, go back to account page
        return redirect()->route('account')->with('status', 'Đơn hàng đã được huỷ');
    }

    // Repurchase a cancelled order: set it back to processing
    public function repurchase($id)
    {
        $order = $this->findUserOrderOrFail($id, ['items']);
        if ($order->status !== 'cancelled') {
            return redirect()->route('account.orders.show', $order->id)->with('error', 'Chỉ có thể mua lại đơn đã huỷ');
        }

        if ($order->items->count() === 0) {
            return redirect()->route('account.orders.show', $order->id)->with('error', 'Không thể mua lại: đơn không có sản phẩm');
        }

        $order->status = 'processing';
        $order->save();

        return redirect()->route('account.orders.show', $order->id)->with('status', 'Đã kích hoạt lại đơn hàng. Bạn có thể thanh toán hoặc chỉnh sửa.');
    }

    // Demo pay action: mark order as paid
    public function pay(Request $request, $id)
    {
        $order = $this->findUserOrder($id, ['items']);
        if (! $order) {
            abort(404);
        }

        // Determine payment method (prefer request, fallback to order)
        $method = $request->input('payment_method', $order->payment_method ?? 'cod');
        $amount = $order->total;

        // Mock payment processing: card -> completed, cod -> pending
        $transactionId = 'TX-' . Str::uuid();
        $paymentStatus = $method === 'card' ? 'completed' : 'pending';

        // Create payment record
        Payment::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'amount' => $amount,
            'method' => $method,
            'transaction_id' => $transactionId,
            'status' => $paymentStatus,
            'metadata' => [
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ],
        ]);

        if ($paymentStatus === 'completed') {
            $order->status = 'paid';
            $order->save();
        }

        $msg = $paymentStatus === 'completed' ? 'Thanh toán thành công' : 'Thanh toán ghi nhận (chờ xử lý)';
        return redirect()->route('account.orders.show', $order->id)->with('status', $msg);
    }

    private function validateOrderData(Request $request): array
    {
        return $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string'],
            'payment_method' => ['nullable', 'string'],
        ]);
    }

    private function isLockedStatus(string $status): bool
    {
        return in_array($status, self::LOCKED_STATUSES, true);
    }

    private function findUserOrder($id, array $with = []): ?Order
    {
        return Order::with($with)
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
    }

    private function findUserOrderOrFail($id, array $with = []): Order
    {
        return Order::with($with)
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }
}
