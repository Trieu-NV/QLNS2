@extends('layouts.app')

@section('title', 'Thêm nhân sự mới')
@section('page-title', 'Thêm nhân sự mới')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Thêm nhân sự mới</h5>
            </div>
            
            <div class="card-body">
                <form action="{{ route('nhan-su.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- Thông tin cơ bản -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Thông tin cơ bản</h6>
                            
                            <div class="mb-3">
                                <label for="ma_nv" class="form-label">Mã nhân viên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('ma_nv') is-invalid @enderror" 
                                       id="ma_nv" name="ma_nv" value="{{ old('ma_nv') }}" required>
                                @error('ma_nv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="ho_ten" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('ho_ten') is-invalid @enderror" 
                                       id="ho_ten" name="ho_ten" value="{{ old('ho_ten') }}" required>
                                @error('ho_ten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="gioi_tinh" class="form-label">Giới tính <span class="text-danger">*</span></label>
                                <select class="form-select @error('gioi_tinh') is-invalid @enderror" 
                                        id="gioi_tinh" name="gioi_tinh" required>
                                    <option value="">Chọn giới tính</option>
                                    <option value="Nam" {{ old('gioi_tinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                                    <option value="Nữ" {{ old('gioi_tinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                    <option value="Khác" {{ old('gioi_tinh') == 'Khác' ? 'selected' : '' }}>Khác</option>
                                </select>
                                @error('gioi_tinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="ngay_sinh" class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('ngay_sinh') is-invalid @enderror" 
                                       id="ngay_sinh" name="ngay_sinh" value="{{ old('ngay_sinh') }}" required>
                                @error('ngay_sinh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="sdt" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control @error('sdt') is-invalid @enderror" 
                                       id="sdt" name="sdt" value="{{ old('sdt') }}">
                                @error('sdt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Thông tin công việc -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-briefcase me-2"></i>Thông tin công việc</h6>
                            
                            <div class="mb-3">
                                <label for="id_chuc_vu" class="form-label">Chức vụ <span class="text-danger">*</span></label>
                                <select class="form-select @error('id_chuc_vu') is-invalid @enderror" 
                                        id="id_chuc_vu" name="id_chuc_vu" required>
                                    <option value="">Chọn chức vụ</option>
                                    @foreach($chucVus as $chucVu)
                                        <option value="{{ $chucVu->id }}" {{ old('id_chuc_vu') == $chucVu->id ? 'selected' : '' }}>
                                            {{ $chucVu->ten_chuc_vu }}
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
                                        <option value="{{ $phongBan->id }}" {{ old('id_phong_ban') == $phongBan->id ? 'selected' : '' }}>
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
                                        <option value="{{ $trinhDo->id }}" {{ old('id_trinh_do') == $trinhDo->id ? 'selected' : '' }}>
                                            {{ $trinhDo->ten_trinh_do }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_trinh_do')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="hinh_anh" class="form-label">Hình ảnh</label>
                                <input type="file" class="form-control @error('hinh_anh') is-invalid @enderror" 
                                       id="hinh_anh" name="hinh_anh" accept="image/*">
                                <div class="form-text">Chấp nhận file: JPG, PNG, GIF. Tối đa 2MB.</div>
                                @error('hinh_anh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="trang_thai" 
                                           name="trang_thai" value="1" {{ old('trang_thai', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="trang_thai">
                                        Trạng thái hoạt động
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Địa chỉ -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Thông tin liên hệ</h6>
                            
                            <div class="mb-3">
                                <label for="dia_chi" class="form-label">Địa chỉ</label>
                                <textarea class="form-control @error('dia_chi') is-invalid @enderror" 
                                          id="dia_chi" name="dia_chi" rows="3" 
                                          placeholder="Nhập địa chỉ chi tiết...">{{ old('dia_chi') }}</textarea>
                                @error('dia_chi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <hr>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('nhan-su.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                                <div>
                                    <button type="reset" class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-undo me-2"></i>Làm mới
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Lưu thông tin
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

@push('scripts')
<script>
// Preview image
document.getElementById('hinh_anh').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Create preview if doesn't exist
            let preview = document.getElementById('image-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.id = 'image-preview';
                preview.className = 'mt-2 img-thumbnail';
                preview.style.maxWidth = '200px';
                preview.style.maxHeight = '200px';
                e.target.parentNode.appendChild(preview);
            }
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Auto generate employee code
document.getElementById('ho_ten').addEventListener('blur', function() {
    const maNvField = document.getElementById('ma_nv');
    if (!maNvField.value) {
        const hoTen = this.value.trim();
        if (hoTen) {
            // Simple auto-generation: take first letters + random number
            const words = hoTen.split(' ');
            let code = '';
            words.forEach(word => {
                if (word.length > 0) {
                    code += word.charAt(0).toUpperCase();
                }
            });
            code += Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            maNvField.value = code;
        }
    }
});
</script>
@endpush