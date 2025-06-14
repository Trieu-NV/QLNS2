@extends('layouts.app')

@section('title', 'Chi tiết nhân sự - ' . $nhanSu->ho_ten)
@section('page-title', 'Chi tiết nhân sự')

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Thông tin cá nhân -->
        <div class="card">
            <div class="card-body text-center">
                @if($nhanSu->hinh_anh)
                    <img src="{{ asset('storage/' . $nhanSu->hinh_anh) }}" alt="{{ $nhanSu->ho_ten }}" 
                         class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <div class="bg-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" 
                         style="width: 150px; height: 150px;">
                        <i class="fas fa-user fa-4x text-white"></i>
                    </div>
                @endif
                
                <h4 class="mb-1">{{ $nhanSu->ho_ten }}</h4>
                <p class="text-muted mb-2">{{ $nhanSu->ma_nv }}</p>
                
                @if($nhanSu->trang_thai)
                    <span class="badge bg-success fs-6"><i class="fas fa-check-circle me-1"></i>Đang hoạt động</span>
                @else
                    <span class="badge bg-warning fs-6"><i class="fas fa-pause-circle me-1"></i>Tạm dừng</span>
                @endif
                
                <hr>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('nhan-su.edit', $nhanSu) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Chỉnh sửa
                    </a>
                    <a href="{{ route('nhan-su.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Thông tin liên hệ -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-address-book me-2"></i>Thông tin liên hệ</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Số điện thoại</label>
                    <p class="mb-0">
                        @if($nhanSu->sdt)
                            <i class="fas fa-phone me-2 text-primary"></i>
                            <a href="tel:{{ $nhanSu->sdt }}">{{ $nhanSu->sdt }}</a>
                        @else
                            <span class="text-muted">Chưa cập nhật</span>
                        @endif
                    </p>
                </div>
                
                <div class="mb-0">
                    <label class="form-label text-muted">Địa chỉ</label>
                    <p class="mb-0">
                        @if($nhanSu->dia_chi)
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                            {{ $nhanSu->dia_chi }}
                        @else
                            <span class="text-muted">Chưa cập nhật</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Thông tin cơ bản -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-user me-2"></i>Thông tin cơ bản</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Mã nhân viên</label>
                            <p class="mb-0 fw-bold">{{ $nhanSu->ma_nv }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Họ và tên</label>
                            <p class="mb-0">{{ $nhanSu->ho_ten }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Giới tính</label>
                            <p class="mb-0">
                                @if($nhanSu->gioi_tinh == 'Nam')
                                    <span class="badge bg-primary">{{ $nhanSu->gioi_tinh }}</span>
                                @elseif($nhanSu->gioi_tinh == 'Nữ')
                                    <span class="badge bg-danger">{{ $nhanSu->gioi_tinh }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $nhanSu->gioi_tinh }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Ngày sinh</label>
                            <p class="mb-0">
                                {{ $nhanSu->ngay_sinh->format('d/m/Y') }}
                                <small class="text-muted">({{ $nhanSu->ngay_sinh->age }} tuổi)</small>
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Ngày tạo</label>
                            <p class="mb-0">{{ $nhanSu->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted">Cập nhật lần cuối</label>
                            <p class="mb-0">{{ $nhanSu->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Thông tin công việc -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-briefcase me-2"></i>Thông tin công việc</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-crown fa-2x text-warning mb-2"></i>
                            <h6 class="mb-1">Chức vụ</h6>
                            <p class="mb-0 fw-bold">{{ $nhanSu->chucVu->ten_chuc_vu ?? 'N/A' }}</p>
                            @if($nhanSu->chucVu && $nhanSu->chucVu->luong_co_ban)
                                <small class="text-muted">Lương CB: {{ number_format($nhanSu->chucVu->luong_co_ban, 0, ',', '.') }} VNĐ</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-building fa-2x text-info mb-2"></i>
                            <h6 class="mb-1">Phòng ban</h6>
                            <p class="mb-0 fw-bold">{{ $nhanSu->phongBan->ten_phong_ban ?? 'N/A' }}</p>
                            @if($nhanSu->phongBan && $nhanSu->phongBan->so_dien_thoai)
                                <small class="text-muted">SĐT: {{ $nhanSu->phongBan->so_dien_thoai }}</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded">
                            <i class="fas fa-graduation-cap fa-2x text-success mb-2"></i>
                            <h6 class="mb-1">Trình độ</h6>
                            <p class="mb-0 fw-bold">{{ $nhanSu->trinhDo->ten_trinh_do ?? 'N/A' }}</p>
                            @if($nhanSu->trinhDo && $nhanSu->trinhDo->loai_bang)
                                <small class="text-muted">{{ $nhanSu->trinhDo->loai_bang }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if($nhanSu->chucVu && $nhanSu->chucVu->mo_ta)
                    <div class="mt-3">
                        <label class="form-label text-muted">Mô tả chức vụ</label>
                        <p class="mb-0">{{ $nhanSu->chucVu->mo_ta }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Thống kê nhanh -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Thống kê</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                            <h6 class="mb-1">Thời gian làm việc</h6>
                            <p class="mb-0 fw-bold">{{ $nhanSu->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-users fa-2x text-info mb-2"></i>
                            <h6 class="mb-1">Cùng phòng ban</h6>
                            <p class="mb-0 fw-bold">{{ $nhanSu->phongBan ? $nhanSu->phongBan->nhanSu->count() : 0 }} người</p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-crown fa-2x text-warning mb-2"></i>
                            <h6 class="mb-1">Cùng chức vụ</h6>
                            <p class="mb-0 fw-bold">{{ $nhanSu->chucVu ? $nhanSu->chucVu->nhanSu->count() : 0 }} người</p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <i class="fas fa-graduation-cap fa-2x text-success mb-2"></i>
                            <h6 class="mb-1">Cùng trình độ</h6>
                            <p class="mb-0 fw-bold">{{ $nhanSu->trinhDo ? $nhanSu->trinhDo->nhanSu->count() : 0 }} người</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection