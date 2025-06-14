@extends('layouts.app')

@section('title', 'Chi tiết Trình độ')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-graduation-cap"></i> Chi tiết Trình độ
                    </h3>
                    <div>
                        <a href="{{ route('trinh-do.edit', $trinhDo) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <a href="{{ route('trinh-do.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-info-circle text-primary"></i> Thông tin cơ bản</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>ID:</strong></td>
                                    <td>{{ $trinhDo->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tên trình độ:</strong></td>
                                    <td><span class="badge bg-primary fs-6">{{ $trinhDo->ten_trinh_do }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Ngày tạo:</strong></td>
                                    <td>{{ $trinhDo->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Cập nhật lần cuối:</strong></td>
                                    <td>{{ $trinhDo->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-align-left text-info"></i> Mô tả</h5>
                            <div class="border rounded p-3 bg-light">
                                @if($trinhDo->mo_ta)
                                    {{ $trinhDo->mo_ta }}
                                @else
                                    <em class="text-muted">Chưa có mô tả</em>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Thống kê nhân sự -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users text-success"></i> Nhân sự có trình độ này
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h2 class="text-primary">{{ $trinhDo->nhanSu->count() }}</h2>
                        <p class="text-muted">Nhân viên</p>
                    </div>
                    
                    @if($trinhDo->nhanSu->count() > 0)
                        <h6>Danh sách nhân viên:</h6>
                        <div class="list-group list-group-flush">
                            @foreach($trinhDo->nhanSu->take(5) as $nhanSu)
                                <div class="list-group-item px-0 py-2">
                                    <div class="d-flex align-items-center">
                                        @if($nhanSu->hinh_anh)
                                            <img src="{{ asset('storage/' . $nhanSu->hinh_anh) }}" 
                                                 class="rounded-circle me-2" 
                                                 width="30" height="30" 
                                                 alt="Avatar">
                                        @else
                                            <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                                 style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <small class="fw-bold">{{ $nhanSu->ho_ten }}</small><br>
                                            <small class="text-muted">{{ $nhanSu->ma_nv }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($trinhDo->nhanSu->count() > 5)
                                <div class="list-group-item px-0 py-2 text-center">
                                    <small class="text-muted">và {{ $trinhDo->nhanSu->count() - 5 }} nhân viên khác...</small>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-3">
                            <a href="{{ route('nhan-su.index', ['trinh_do' => $trinhDo->id]) }}" 
                               class="btn btn-sm btn-outline-primary w-100">
                                <i class="fas fa-list"></i> Xem tất cả nhân viên
                            </a>
                        </div>
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <p>Chưa có nhân viên nào có trình độ này</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Thao tác nhanh -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-cogs"></i> Thao tác nhanh
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('trinh-do.edit', $trinhDo) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Chỉnh sửa trình độ
                        </a>
                        
                        @if($trinhDo->nhanSu->count() == 0)
                            <form action="{{ route('trinh-do.destroy', $trinhDo) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa trình độ này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash"></i> Xóa trình độ
                                </button>
                            </form>
                        @else
                            <button class="btn btn-danger" disabled title="Không thể xóa vì đang có nhân viên">
                                <i class="fas fa-trash"></i> Không thể xóa
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection