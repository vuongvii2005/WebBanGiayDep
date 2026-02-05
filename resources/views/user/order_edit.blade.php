@extends('layouts.user')
@section('title', 'Chỉnh sửa đơn hàng')

@section('content')
  <div class="container py-5">
    <h1 class="mb-4">Chỉnh sửa đơn hàng #{{ $order->id }}</h1>

    <div class="card p-4 mb-4">
      <form method="POST" action="{{ route('account.orders.update', $order) }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Họ và tên</label>
          <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $order->fullname) }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email', $order->email) }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Địa chỉ</label>
          <input type="text" name="address" class="form-control" value="{{ old('address', $order->address) }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Phương thức thanh toán</label>
          <select name="payment_method" class="form-select">
            <option value="cod" {{ $order->payment_method === 'cod' ? 'selected' : ''}}>Thanh toán khi nhận hàng</option>
            <option value="card" {{ $order->payment_method === 'card' ? 'selected' : ''}}>Thẻ ngân hàng</option>
          </select>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
          <a href="{{ route('account.orders.show', $order) }}" class="btn btn-outline-gray">Hủy</a>
        </div>
      </form>
    </div>

  </div>
@endsection
