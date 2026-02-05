@extends('layouts.user')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-12">
      <div class="card p-4">
        <h3>Đơn hàng #{{ $order->id }}</h3>
        <p class="text-muted">Ngày: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Người nhận:</strong> {{ $order->fullname }} &nbsp; <strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        <hr>
        <h5>Sản phẩm</h5>
        @if($order->status === 'processing')
          <form method="POST" action="{{ route('account.orders.updateItems', $order) }}">
            @csrf
            <ul class="list-group mb-3">
              @foreach($order->items as $it)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center gap-3">
                    <div style="width: 60px; height: 60px; flex-shrink: 0;">
                      @php
                        $imageIndex = 1;
                        if (isset($it->product->sku) && preg_match('/^(men|women)-(\d+)$/', $it->product->sku, $m)) {
                          $num = (int)$m[2];
                          $imageIndex = ($num % 10) + 1;
                        } elseif ($it->product_id) {
                          $imageIndex = (((int)$it->product_id % 10) + 1);
                        }
                        $imageUrl = asset("user/images/card-item{$imageIndex}.jpg");
                      @endphp
                      <img src="{{ $imageUrl }}" alt="{{ $it->name }}" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div>
                      <div class="fw-bold">{{ $it->name }}</div>
                      @if(!empty($it->size))
                        <div><small class="text-muted">Size: {{ $it->size }}</small></div>
                      @endif
                      @if($it->color)
                        <small class="text-muted">Màu sắc: {{ $it->color }}</small><br>
                      @endif
                    </div>
                  </div>

                  <div style="width:220px;text-align:right;">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                      <input type="number" name="items[{{ $it->id }}][qty]" value="{{ $it->qty }}" min="0" class="form-control form-control-sm" style="width:80px;">
                      <label class="form-check-label small text-muted ms-2">
                        <input type="checkbox" name="items[{{ $it->id }}][remove]" value="1"> Xóa
                      </label>
                      <div class="fw-bold ms-3">{{ number_format($it->total, 0, ',', '.') }} ₫</div>
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>

            <div class="d-flex gap-2 mb-3">
              <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
              <a href="{{ route('account.orders.show', $order) }}" class="btn btn-outline-gray">Quay lại</a>
            </div>
          </form>
        @else
          <ul class="list-group mb-3">
            @foreach($order->items as $it)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                  <div style="width: 60px; height: 60px; flex-shrink: 0;">
                    @php
                      $imageIndex = 1;
                      if (isset($it->product->sku) && preg_match('/^(men|women)-(\d+)$/', $it->product->sku, $m)) {
                        $num = (int)$m[2];
                        $imageIndex = ($num % 10) + 1;
                      } elseif ($it->product_id) {
                        $imageIndex = (((int)$it->product_id % 10) + 1);
                      }
                      $imageUrl = asset("user/images/card-item{$imageIndex}.jpg");
                    @endphp
                    <img src="{{ $imageUrl }}" alt="{{ $it->name }}" class="img-fluid rounded" style="width: 100%; height: 100%; object-fit: cover;">
                  </div>
                  <div>
                    <div class="fw-bold">{{ $it->name }}</div>
                    <small class="text-muted">Số lượng: {{ $it->qty }}</small>
                    @if(!empty($it->size))
                      <div><small class="text-muted">Size: {{ $it->size }}</small></div>
                    @endif
                    @if($it->color)
                      <small class="text-muted">Màu sắc: {{ $it->color }}</small><br>
                    @endif
                  </div>
                </div>
                <div class="fw-bold">{{ number_format($it->total, 0, ',', '.') }} ₫</div>
              </li>
            @endforeach
          </ul>
        @endif
        <div class="d-flex justify-content-end align-items-center gap-3">
          <div class="text-end">
            <div>Subtotal: {{ number_format($order->subtotal, 0, ',', '.') }} ₫</div>
            <div>Shipping: {{ number_format($order->shipping, 0, ',', '.') }} ₫</div>
            <div class="fw-bold">Total: {{ number_format($order->total, 0, ',', '.') }} ₫</div>
          </div>
        </div>
        <div class="mt-3">
          @if($order->status !== 'paid')
            <div class="d-flex gap-2 align-items-center">
              <form method="POST" action="{{ route('account.orders.updatePaymentMethod', $order) }}" class="d-flex gap-2 align-items-center">
                @csrf
                <label class="me-2 mb-0">Phương thức:</label>
                <select name="payment_method" class="form-select form-select-sm" style="width:220px;">
                  <option value="cod" {{ $order->payment_method === 'cod' ? 'selected' : ''}}>Thanh toán khi nhận hàng</option>
                  <option value="card" {{ $order->payment_method === 'card' ? 'selected' : ''}}>Thẻ ngân hàng</option>
                </select>
                <button type="submit" class="btn btn-outline-primary btn-sm">Cập nhật phương thức</button>
              </form>

              <a href="{{ route('account.orders.edit', $order) }}" class="btn btn-secondary btn-sm">Chỉnh sửa đơn hàng</a>

              @if($order->status === 'cancelled')
                <form method="POST" action="{{ route('account.orders.repurchase', $order) }}" onsubmit="return confirm('Bạn có chắc chắn muốn mua lại đơn này?');">
                  @csrf
                  <button class="btn btn-success btn-sm">Mua lại</button>
                </form>
              @else
                <form method="POST" action="{{ url('/account/orders/'.$order->id.'/pay') }}">
                  @csrf
                  <button class="btn btn-primary btn-sm">Thanh toán</button>
                </form>
              @endif

              @if($order->status === 'processing')
                <form method="POST" action="{{ route('account.orders.cancel', $order) }}" onsubmit="return confirm('Bạn có chắc muốn huỷ đơn?');">
                  @csrf
                  <button class="btn btn-danger btn-sm">Huỷ đơn</button>
                </form>
              @endif
            </div>
          @else
            <span class="badge bg-success">Đã thanh toán</span>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
