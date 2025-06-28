@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Chi tiết tài khoản</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Username:</strong> {{ $user->username }}</p>
                            <p><strong>Loại tài khoản:</strong> 
                                @switch($user->loaitk)
                                    @case(0)
                                        <span class="badge bg-danger">Admin</span>
                                        @break
                                    @case(1)
                                        <span class="badge bg-primary">HR</span>
                                        @break
                                    @case(2)
                                        <span class="badge bg-success">Tổ trưởng</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">Không xác định</span>
                                @endswitch
                            </p>
                            <p><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Số điện thoại:</strong> {{ $user->sdt ?? 'N/A' }}</p>
                            <p><strong>Thông tin:</strong> {{ $user->info ?? 'N/A' }}</p>
                            <p><strong>Ngày tạo:</strong> {{ $user->created_at ? $user->created_at->format('d/m/Y H:i:s') : 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('users.edit', $user->username) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 