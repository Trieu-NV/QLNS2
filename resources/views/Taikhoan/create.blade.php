@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tạo tài khoản mới') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('taikhoan.store') }}">
                        @csrf

                        <div class="form-group row mb-3">
                            <label class="col-md-4 col-form-label text-md-right">Tên đăng nhập</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="username" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-4 col-form-label text-md-right">Mật khẩu</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-4 col-form-label text-md-right">Quyền</label>
                            <div class="col-md-6">
                                <select class="form-control" name="role" required>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Tạo tài khoản
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection