@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quản lý tài khoản</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm tài khoản mới
        </a>
    </div>

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

    <form method="GET" class="mb-3 row g-2">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm tài khoản, email, SĐT, thông tin..." value="{{ request('search', $search ?? '') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">Đặt lại</a>
        </div>
    </form>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Loại tài khoản</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Thông tin</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->username }}</td>
                            <td>
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
                            </td>
                            <td>{{ $user->email ?? 'N/A' }}</td>
                            <td>{{ $user->sdt ?? 'N/A' }}</td>
                            <td>{{ $user->info ?? 'N/A' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('users.show', $user->username) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->username) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->username) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 