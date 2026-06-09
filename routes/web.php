<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Auth
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Front controllers
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;

// Support controllers
use App\Http\Controllers\SupportController;
use App\Http\Controllers\ChatController;

// Admin controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SupportController as AdminSupportController;


/*
|--------------------------------------------------------------------------
| Health check / quick test
|--------------------------------------------------------------------------
*/
Route::get('/test-admin', function () {
    return 'Laravel is working! Server time: ' . now();
});

/*
|--------------------------------------------------------------------------
| Front site
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index']);
Route::get('/index', [ProductController::class, 'index']);

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/account', function () {
    $orders = \App\Models\Order::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
    return view('user.account', compact('orders'));
})->middleware('auth')->name('account');

// Account edit
Route::get('/account/edit', function () {
    $user = auth()->user();
    return view('user.account_edit', compact('user'));
})->middleware('auth')->name('account.edit');

Route::post('/account/edit', function (Illuminate\Http\Request $request) {
    $user = auth()->user();
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . $user->id],
    ]);

    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->username = $data['username'] ?? $user->username;
    $user->save();

    return redirect('/account')->with('status', 'Cập nhật thông tin thành công');
})->middleware('auth')->name('account.update');

// Change password
Route::get('/account/password', function () {
    $user = auth()->user();
    return view('user.account_password', compact('user'));
})->middleware('auth')->name('account.password');

Route::post('/account/password', function (Illuminate\Http\Request $request) {
    $user = auth()->user();
    $data = $request->validate([
        'current_password' => ['required'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    if (!\Illuminate\Support\Facades\Hash::check($data['current_password'], $user->password)) {
        return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng'])->withInput();
    }

    $user->password = \Illuminate\Support\Facades\Hash::make($data['password']);
    $user->save();

    return redirect('/account')->with('status', 'Đổi mật khẩu thành công');
})->middleware('auth')->name('account.password.update');

// User-facing order detail
Route::get('/account/orders/{order}', [OrderController::class, 'show'])->middleware('auth')->name('account.orders.show');
Route::get('/account/orders/{order}/edit', [OrderController::class, 'edit'])->middleware('auth')->name('account.orders.edit');
Route::post('/account/orders/{order}', [OrderController::class, 'update'])->middleware('auth')->name('account.orders.update');
Route::post('/account/orders/{order}/payment-method', [OrderController::class, 'updatePaymentMethod'])->middleware('auth')->name('account.orders.updatePaymentMethod');
Route::post('/account/orders/{order}/items', [OrderController::class, 'updateItems'])->middleware('auth')->name('account.orders.updateItems');
Route::post('/account/orders/{order}/cancel', [OrderController::class, 'cancel'])->middleware('auth')->name('account.orders.cancel');
Route::post('/account/orders/{order}/repurchase', [OrderController::class, 'repurchase'])->middleware('auth')->name('account.orders.repurchase');
Route::post('/account/orders/{order}/pay', [OrderController::class, 'pay'])->middleware('auth')->name('account.orders.pay');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/buy-now', [CartController::class, 'buyNow'])->name('cart.buyNow'); // Buy-now: set single-item checkout
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/add-sample', [CartController::class, 'addSample'])->name('cart.add.sample');

Route::middleware('auth')->group(function () {
    Route::view('/checkout', 'user.checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
});

Route::view('/men', 'user.men');
Route::view('/women', 'user.women');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/api/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

// Support routes (protected by auth)
Route::middleware('auth')->group(function () {
    Route::get('/support', [SupportController::class, 'index'])->name('support.index');
    Route::get('/support/create', [SupportController::class, 'create'])->name('support.create');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');
    Route::get('/support/{ticket}', [SupportController::class, 'show'])->name('support.show');
    Route::post('/support/{ticket}/response', [SupportController::class, 'addResponse'])->name('support.addResponse');
    Route::post('/support/{ticket}/close', [SupportController::class, 'close'])->name('support.close');
});

// Chat routes (protected by auth)
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/history/{sessionId}', [ChatController::class, 'getHistory'])->name('chat.history');
});

/*
|--------------------------------------------------------------------------
| Policy Pages (Public)
|--------------------------------------------------------------------------
*/
Route::view('/policies/shipping', 'policies.shipping')->name('policies.shipping');
Route::view('/policies/return', 'policies.return')->name('policies.return');
Route::view('/policies/warranty', 'policies.warranty')->name('policies.warranty');
Route::view('/policies/payment', 'policies.payment')->name('policies.payment');
Route::view('/policies/privacy', 'policies.privacy')->name('policies.privacy');
Route::view('/policies/terms', 'policies.terms')->name('policies.terms');

// Register
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::redirect('/admin', '/admin/dashboard')->name('admin');

Route::prefix('admin')->name('admin.')->middleware(['auth','is_admin'])->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);

    // Products
    Route::get('products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // Categories
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Users
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('users/{user}/ban', [AdminUserController::class, 'ban'])->name('users.ban');
    Route::post('users/{user}/unban', [AdminUserController::class, 'unban'])->name('users.unban');

    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('orders/{order}/approve', [AdminOrderController::class, 'approve'])->name('orders.approve');
    Route::post('orders/{order}/reject', [AdminOrderController::class, 'reject'])->name('orders.reject');

    // Support tickets (admin)
    Route::get('support', [AdminSupportController::class, 'index'])->name('support.index');
    Route::get('support/{ticket}', [AdminSupportController::class, 'show'])->name('support.show');
    Route::post('support/{ticket}/status', [AdminSupportController::class, 'updateStatus'])->name('support.updateStatus');
    Route::post('support/{ticket}/priority', [AdminSupportController::class, 'updatePriority'])->name('support.updatePriority');
    Route::delete('support/{ticket}', [AdminSupportController::class, 'destroy'])->name('support.destroy');

    // Static pages / samples
    Route::view('charts', 'admin.charts');
    Route::view('tables', 'admin.tables');
});


/*
|--------------------------------------------------------------------------
| Local-only helpers (debug/impersonate)
|--------------------------------------------------------------------------
*/
if (app()->environment('local')) {
    Route::get('/admin/debug', function (Request $request) {
        $user = auth()->user();
        return response()->json([
            'auth_check' => auth()->check(),
            'user_id' => auth()->id(),
            'user' => $user ? [
                'id' => $user->id,
                'email' => $user->email ?? null,
                'username' => $user->username ?? null,
                'is_admin' => (bool) ($user->is_admin ?? false),
            ] : null,
            'session_cookie_name' => config('session.cookie'),
            'session_cookie_value' => $request->cookie(config('session.cookie')),
            'server_session_id' => session()->getId(),
        ]);
    });

    Route::get('/admin/impersonate-admin', function () {
        $email = env('APP_ADMIN_EMAIL', 'admin@example.com');
        $user = \App\Models\User::where('email', $email)->first();
        if (!$user) {
            return response('Admin user not found: ' . $email, 404);
        }
        auth()->loginUsingId($user->id);
        session()->regenerate();
        return redirect('/admin');
    });
}
