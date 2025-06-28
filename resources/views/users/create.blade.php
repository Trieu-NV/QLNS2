@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Thêm tài khoản mới</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username *</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="loaitk" class="form-label">Loại tài khoản *</label>
                            <select class="form-control" id="loaitk" name="loaitk" required>
                                <option value="">Chọn loại tài khoản</option>
                                <option value="0" {{ old('loaitk') == 0 ? 'selected' : '' }}>Admin</option>
                                <option value="1" {{ old('loaitk') == 1 ? 'selected' : '' }}>HR</option>
                                <option value="2" {{ old('loaitk') == 2 ? 'selected' : '' }}>Tổ trưởng</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label for="sdt" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="sdt" name="sdt" value="{{ old('sdt') }}">
                        </div>

                        <div class="mb-3">
                            <label for="info" class="form-label">Thông tin</label>
                            <textarea class="form-control" id="info" name="info" rows="3">{{ old('info') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-primary">Thêm tài khoản</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 