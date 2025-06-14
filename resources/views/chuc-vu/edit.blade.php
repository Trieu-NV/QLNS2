@extends('layouts.app')

@section('title', 'Chỉnh sửa Chức vụ')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-edit"></i> Chỉnh sửa Chức vụ
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('chuc-vu.update', $chucVu) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Tên chức vụ -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ten_chuc_vu" class="form-label">
                                        <i class="fas fa-user-tie"></i> Tên chức vụ <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('ten_chuc_vu') is-invalid @enderror" 
                                           id="ten_chuc_vu" 
                                           name="ten_chuc_vu" 
                                           value="{{ old('ten_chuc_vu', $chucVu->ten_chuc_vu) }}"
                                           placeholder="Nhập tên chức vụ"
                                           required>
                                    @error('ten_chuc_vu')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Thông tin hiện tại -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-info-circle"></i> Thông tin hiện tại
                                    </label>
                                    <div class="border rounded p-2 bg-light">
                                        <small class="text-muted">
                                            <strong>ID:</strong> {{ $chucVu->id }}<br>
                                            <strong>Tạo lúc:</strong> {{ $chucVu->created_at->format('d/m/Y H:i') }}<br>
                                            <strong>Nhân viên:</strong> {{ $chucVu->nhanSu->count() }} người
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mô tả -->
                        <div class="mb-3">
                            <label for="mo_ta" class="form-label">
                                <i class="fas fa-align-left"></i> Mô tả
                            </label>
                            <textarea class="form-control @error('mo_ta') is-invalid @enderror" 
                                      id="mo_ta" 
                                      name="mo_ta" 
                                      rows="4"
                                      placeholder="Nhập mô tả về chức vụ (không bắt buộc)">{{ old('mo_ta', $chucVu->mo_ta) }}</textarea>
                            @error('mo_ta')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Cảnh báo nếu có nhân viên -->
                        @if($chucVu->nhanSu->count() > 0)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Lưu ý:</strong> Chức vụ này đang được sử dụng bởi {{ $chucVu->nhanSu->count() }} nhân viên. 
                                Việc thay đổi thông tin có thể ảnh hưởng đến dữ liệu nhân sự.
                            </div>
                        @endif
                        
                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('chuc-vu.show', $chucVu) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                                <a href="{{ route('chuc-vu.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-list"></i> Danh sách
                                </a>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật chức vụ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto focus vào trường đầu tiên
    $('#ten_chuc_vu').focus();
    
    // Xác nhận trước khi submit
    $('form').on('submit', function(e) {
        if (!confirm('Bạn có chắc chắn muốn cập nhật chức vụ này?')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection