@extends('layouts.user')

@section('title', 'Chỉnh sửa tài khoản')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-6">
      <div class="card p-4 shadow-sm">
        <h4 class="mb-3">Chỉnh sửa thông tin cá nhân</h4>

        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ url('/account/edit') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Tên đăng nhập (username)</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}">
          </div>

          <div class="d-grid gap-2">
            <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
            <a href="{{ url('/account') }}" class="btn btn-outline-secondary">Hủy</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
