@extends('layouts.app')

@section('title', 'Chỉnh sửa nhân sự - ' . $nhanSu->ho_ten)
@section('page-title', 'Chỉnh sửa nhân sự')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Chỉnh sửa thông tin nhân sự</h5>
                @if($nhanSu)
                     <a href="{{ route('nhan-su.show', $nhanSu->ma_nv) }}" class="btn btn-outline-secondary btn-sm">
                         <i class="fas fa-arrow-left me-1"></i>Quay lại
                     </a>
                 @else
                     <button class="btn btn-outline-secondary btn-sm" disabled>
                         <i class="fas fa-arrow-left me-1"></i>Quay lại
                     </button>
                 @endif
            </div>
            <div class="card-body">
                <form action="{{ route('nhan-su.update', $nhanSu->ma_nv) }}" method="POST" enctype="multipart/form-data" id="editForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Cột trái -->
                        <div class="col-md-6">
                            <!-- Thông tin cơ bản -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Thông tin cơ bản</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="ma_nv" class="form-label">Mã nhân viên <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('ma_nv') is-invalid @enderror" 
                                               id="ma_nv" name="ma_nv" value="{{ old('ma_nv', $nhanSu->ma_nv) }}" required>
                                        @error('ma_nv')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="ho_ten" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('ho_ten') is-invalid @enderror" 
                                               id="ho_ten" name="ho_ten" value="{{ old('ho_ten', $nhanSu->ho_ten) }}" required>
                                        @error('ho_ten')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="gioi_tinh" class="form-label">Giới tính <span class="text-danger">*</span></label>
                                                <select class="form-select @error('gioi_tinh') is-invalid @enderror" 
                                                        id="gioi_tinh" name="gioi_tinh" required>
                                                    <option value="">Chọn giới tính</option>
                                                    <option value="Nam" {{ old('gioi_tinh', $nhanSu->gioi_tinh) == 'Nam' ? 'selected' : '' }}>Nam</option>
                                                    <option value="Nữ" {{ old('gioi_tinh', $nhanSu->gioi_tinh) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                                    <option value="Khác" {{ old('gioi_tinh', $nhanSu->gioi_tinh) == 'Khác' ? 'selected' : '' }}>Khác</option>
                                                </select>
                                                @error('gioi_tinh')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="ngay_sinh" class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control @error('ngay_sinh') is-invalid @enderror" 
                                                       id="ngay_sinh" name="ngay_sinh" 
                                                       value="{{ old('ngay_sinh', $nhanSu->ngay_sinh->format('Y-m-d')) }}" required>
                                                @error('ngay_sinh')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="sdt" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control @error('sdt') is-invalid @enderror" 
                                               id="sdt" name="sdt" value="{{ old('sdt', $nhanSu->sdt) }}" 
                                               placeholder="Nhập số điện thoại">
                                        @error('sdt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Thông tin liên hệ -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-address-book me-2"></i>Thông tin liên hệ</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="dia_chi" class="form-label">Địa chỉ</label>
                                        <textarea class="form-control @error('dia_chi') is-invalid @enderror" 
                                                  id="dia_chi" name="dia_chi" rows="3" 
                                                  placeholder="Nhập địa chỉ">{{ old('dia_chi', $nhanSu->dia_chi) }}</textarea>
                                        @error('dia_chi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Cột phải -->
                        <div class="col-md-6">
                            <!-- Hình ảnh -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-image me-2"></i>Hình ảnh</h6>
                                </div>
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <div id="imagePreview" class="mb-3">
                                            @if($nhanSu->hinh_anh)
                                                <img src="{{ asset('storage/' . $nhanSu->hinh_anh) }}" alt="{{ $nhanSu->ho_ten }}" 
                                                     class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                                                     style="width: 150px; height: 150px;">
                                                    <i class="fas fa-user fa-4x text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <input type="file" class="form-control @error('hinh_anh') is-invalid @enderror" 
                                               id="hinh_anh" name="hinh_anh" accept="image/*">
                                        <small class="form-text text-muted">Chọn file ảnh (JPG, PNG, GIF). Tối đa 2MB.</small>
                                        @error('hinh_anh')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Thông tin công việc -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-briefcase me-2"></i>Thông tin công việc</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="id_chuc_vu" class="form-label">Chức vụ <span class="text-danger">*</span></label>
                                        <select class="form-select @error('id_chuc_vu') is-invalid @enderror" 
                                                id="id_chuc_vu" name="id_chuc_vu" required>
                                            <option value="">Chọn chức vụ</option>
                                            @foreach($chucVus as $chucVu)
                                                <option value="{{ $chucVu->id }}" 
                                                        {{ old('id_chuc_vu', $nhanSu->id_chuc_vu) == $chucVu->id ? 'selected' : '' }}>
                                                    {{ $chucVu->ten_chuc_vu }}
                                                    @if($chucVu->luong_co_ban)
                                                        ({{ number_format($chucVu->luong_co_ban, 0, ',', '.') }} VNĐ)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_chuc_vu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="id_phong_ban" class="form-label">Phòng ban <span class="text-danger">*</span></label>
                                        <select class="form-select @error('id_phong_ban') is-invalid @enderror" 
                                                id="id_phong_ban" name="id_phong_ban" required>
                                            <option value="">Chọn phòng ban</option>
                                            @foreach($phongBans as $phongBan)
                                                <option value="{{ $phongBan->id }}" 
                                                        {{ old('id_phong_ban', $nhanSu->id_phong_ban) == $phongBan->id ? 'selected' : '' }}>
                                                    {{ $phongBan->ten_phong_ban }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_phong_ban')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="id_trinh_do" class="form-label">Trình độ <span class="text-danger">*</span></label>
                                        <select class="form-select @error('id_trinh_do') is-invalid @enderror" 
                                                id="id_trinh_do" name="id_trinh_do" required>
                                            <option value="">Chọn trình độ</option>
                                            @foreach($trinhDos as $trinhDo)
                                                <option value="{{ $trinhDo->id }}" 
                                                        {{ old('id_trinh_do', $nhanSu->id_trinh_do) == $trinhDo->id ? 'selected' : '' }}>
                                                    {{ $trinhDo->ten_trinh_do }}
                                                    @if($trinhDo->loai_bang)
                                                        ({{ $trinhDo->loai_bang }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_trinh_do')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="trang_thai" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                        <select class="form-select @error('trang_thai') is-invalid @enderror" 
                                                id="trang_thai" name="trang_thai" required>
                                            <option value="1" {{ old('trang_thai', $nhanSu->trang_thai) == '1' ? 'selected' : '' }}>Đang hoạt động</option>
                                            <option value="0" {{ old('trang_thai', $nhanSu->trang_thai) == '0' ? 'selected' : '' }}>Tạm dừng</option>
                                        </select>
                                        @error('trang_thai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nút hành động -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    @if($nhanSu)
                                          <a href="{{ route('nhan-su.show', $nhanSu->ma_nv) }}" class="btn btn-outline-secondary">
                                              <i class="fas fa-times me-2"></i>Hủy bỏ
                                          </a>
                                      @else
                                          <button class="btn btn-outline-secondary" disabled>
                                              <i class="fas fa-times me-2"></i>Hủy bỏ
                                          </button>
                                      @endif
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Cập nhật
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Xem trước hình ảnh
document.getElementById('hinh_anh').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview" 
                     class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
            `;
        };
        reader.readAsDataURL(file);
    }
});

// Xác nhận trước khi submit
document.getElementById('editForm').addEventListener('submit', function(e) {
    if (!confirm('Bạn có chắc chắn muốn cập nhật thông tin nhân sự này?')) {
        e.preventDefault();
    }
});
</script>
@endsection