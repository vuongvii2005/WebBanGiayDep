@extends('layouts.user')

@section('title', 'Tài khoản của tôi')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-12 col-md-4">
            <div class="card p-4 shadow-sm">
                <div class="d-flex align-items-center">
                    <div class="avatar bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width:76px;height:76px;font-size:28px;font-weight:700;color:#333;">
                        {{ strtoupper(substr(auth()->user()->name ?? (auth()->user()->email ?? 'U'),0,1)) }}
                    </div>
                    <div>
                        <h4 class="mb-0">{{ auth()->user()->name }}</h4>
                        <small class="text-muted d-block">{{ auth()->user()->email }}</small>
                    </div>
                </div>

                <hr>
                <ul class="list-unstyled small mb-3">
                    <li><strong>ID:</strong> {{ auth()->user()->id }}</li>
                    <li><strong>Username:</strong> {{ auth()->user()->username ?? '-' }}</li>
                    <li><strong>Admin:</strong> {{ auth()->user()->is_admin ? 'Có' : 'Không' }}</li>
                </ul>

                <div class="d-grid gap-2">
                    <a href="{{ url('/account/edit') }}" class="btn btn-outline-secondary">Chỉnh sửa thông tin</a>
                    <a href="{{ url('/account/password') }}" class="btn btn-outline-primary">Đổi mật khẩu</a>
                    <a href="{{ route('support.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-headset"></i> Hỗ trợ khách hàng
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Đăng xuất</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-8">
            <div class="card p-4 mb-4 shadow-sm">
                <h5 class="mb-3">Đơn hàng gần đây</h5>
                @if(isset($orders) && count($orders))
                    <ul class="list-group">
                        @foreach($orders as $order)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('account.orders.show', $order) }}" class="fw-bold text-decoration-none">Đơn hàng #{{ $order->id }}</a>
                                    <small class="text-muted d-block">Ngày đặt: {{ $order->created_at->format('d/m/Y') }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">{{ number_format($order->total, 0, ',', '.') }} ₫</div>
                                    <span class="badge bg-{{ \App\Helpers\OrderHelper::getStatusBadgeColor($order->status) }}">
                                        {{ \App\Helpers\OrderHelper::getStatusLabel($order->status) }}
                                    </span>
                                    <div class="mt-2">
                                        <a href="{{ route('account.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center text-muted py-4">Bạn chưa có đơn hàng nào. <a href="{{ url('/') }}">Mua sắm ngay</a></div>
                @endif
            </div>

            <div class="card p-4 shadow-sm">
                <h5 class="mb-3">Cài đặt tài khoản</h5>
                <p class="small text-muted mb-0">Bạn có thể quản lý thông tin cá nhân, thay đổi mật khẩu và xem lịch sử đơn hàng tại đây.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Account page local styles */
    .avatar { background: linear-gradient(135deg,#f3f4f6,#e9ecef); color:#1f2937; font-weight:800 }
    .card { border-radius: 10px; }
    .list-group-item { border: none; border-bottom: 1px solid #f1f1f1; padding: 18px 20px; }
    .list-group-item:last-child { border-bottom: none }
    .list-group-item:hover { background: #fafafa }
    .fw-bold { color: #111827 }
    .text-muted { color: #6b7280 }
    .badge { font-size: 0.8rem; padding: 0.45em 0.55em }
    .card p.small { color: #6b7280 }
    @media (min-width: 992px) {
        .container.py-5 { max-width: 980px }
    }
</style>
@endpush

