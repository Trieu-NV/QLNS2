@extends('layouts.app')

@section('title', 'Quản lý Trình độ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Danh sách Trình độ</h3>
                    <a href="{{ route('trinh-do.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm mới
                    </a>
                </div>
                <div class="card-body">
                    <!-- Form tìm kiếm và sắp xếp -->
                    <form method="GET" action="{{ route('trinh-do.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Tìm kiếm theo tên trình độ..." 
                                           value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="sort_by" class="form-select">
                                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                                    <option value="ten_trinh_do" {{ request('sort_by') == 'ten_trinh_do' ? 'selected' : '' }}>Tên trình độ</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="sort_order" class="form-select">
                                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary w-100">
                                    <i class="fas fa-sort"></i> Sắp xếp
                                </button>
                            </div>
                            <div class="col-md-1">
                                <a href="{{ route('trinh-do.index') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-refresh"></i>
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Bảng danh sách -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%">STT</th>
                                    <th width="25%">Tên trình độ</th>
                                    <th width="40%">Mô tả</th>
                                    <th width="15%">Số nhân sự</th>
                                    <th width="15%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trinhDos as $index => $trinhDo)
                                    <tr>
                                        <td>{{ $trinhDos->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $trinhDo->ten_trinh_do }}</strong>
                                        </td>
                                        <td>
                                            {{ $trinhDo->mo_ta ? Str::limit($trinhDo->mo_ta, 100) : 'Chưa có mô tả' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $trinhDo->nhan_su_count ?? 0 }} người</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('trinh-do.show', $trinhDo) }}" 
                                                   class="btn btn-sm btn-info" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('trinh-do.edit', $trinhDo) }}" 
                                                   class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('trinh-do.destroy', $trinhDo) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa trình độ này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Không có dữ liệu trình độ nào.</p>
                                            <a href="{{ route('trinh-do.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Thêm trình độ đầu tiên
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Phân trang -->
                    <!-- @if($trinhDos->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $trinhDos->appends(request()->query())->links() }}
                        </div>
                    @endif -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection