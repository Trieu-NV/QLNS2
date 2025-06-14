@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông Tin Cá Nhân</h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.update-profile') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" value="{{ $user->username }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="info" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control @error('info') is-invalid @enderror" 
                                id="info" name="info" value="{{ old('info', $user->info) }}" required>
                            @error('info')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sdt" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control @error('sdt') is-invalid @enderror" 
                                id="sdt" name="sdt" value="{{ old('sdt', $user->sdt) }}" required>
                            @error('sdt')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="loaitk" class="form-label">Loại tài khoản</label>
                            <input type="text" class="form-control" id="loaitk" 
                                value="{{ $user->loaitk == 0 ? 'Admin' : ($user->loaitk == 1 ? 'Quản lý' : 'Người dùng') }}" 
                                disabled>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                Cập nhật thông tin
                            </button>
                            <a href="{{ route('user.change-password') }}" class="btn btn-secondary">
                                Đổi mật khẩu
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection