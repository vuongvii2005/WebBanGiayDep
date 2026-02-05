@extends('layouts.user')

@section('title', 'Đổi mật khẩu')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-6">
      <div class="card p-4 shadow-sm">
        <h4 class="mb-3">Đổi mật khẩu</h4>

        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ url('/account/password') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Mật khẩu hiện tại</label>
            <input type="password" name="current_password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Mật khẩu mới</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>

          <div class="d-grid gap-2">
            <button class="btn btn-primary" type="submit">Đổi mật khẩu</button>
            <a href="{{ url('/account') }}" class="btn btn-outline-secondary">Hủy</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
