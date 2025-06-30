@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Thông Tin Tài Khoản</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tài Khoản:</label>
                                <p class="form-control-plaintext">{{ $user->username }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Loại Tài Khoản:</label>
                                <p class="form-control-plaintext">
                                    @switch($user->loaitk)
                                        @case(0)
                                            <span class="badge bg-danger">Admin</span>
                                            @break
                                        @case(1)
                                            <span class="badge bg-primary">HR</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-success">Tổ Trưởng</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Không xác định</span>
                                    @endswitch
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email:</label>
                                <p class="form-control-plaintext">{{ $user->email ?? 'Chưa cập nhật' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Số Điện Thoại:</label>
                                <p class="form-control-plaintext">{{ $user->sdt ?? 'Chưa cập nhật' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($user->info)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Thông Tin Bổ Sung:</label>
                            <p class="form-control-plaintext">{{ $user->info }}</p>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/profile/edit') }}" class="btn btn-success">
                            <i class="fas fa-edit"></i> Cập nhật thông tin
                        </a>
                        <a href="{{ route('password.change') }}" class="btn btn-primary">
                            <i class="fas fa-key"></i> Đổi Mật Khẩu
                        </a>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay Lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 