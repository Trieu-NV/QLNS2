@extends('layouts.app')

@section('title', 'Chỉnh sửa Trình độ')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-edit"></i> Chỉnh sửa Trình độ
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('trinh-do.update', $trinhDo) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Tên trình độ -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ten_trinh_do" class="form-label">
                                        <i class="fas fa-graduation-cap"></i> Tên trình độ <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('ten_trinh_do') is-invalid @enderror" 
                                           id="ten_trinh_do" 
                                           name="ten_trinh_do" 
                                           value="{{ old('ten_trinh_do', $trinhDo->ten_trinh_do) }}"
                                           placeholder="Nhập tên trình độ"
                                           required>
                                    @error('ten_trinh_do')
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
                                            <strong>ID:</strong> {{ $trinhDo->id }}<br>
                                            <strong>Tạo lúc:</strong> {{ $trinhDo->created_at->format('d/m/Y H:i') }}<br>
                                            <strong>Nhân viên:</strong> {{ $trinhDo->nhanSu->count() }} người
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
                                      placeholder="Nhập mô tả về trình độ (không bắt buộc)">{{ old('mo_ta', $trinhDo->mo_ta) }}</textarea>
                            @error('mo_ta')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Cảnh báo nếu có nhân viên -->
                        @if($trinhDo->nhanSu->count() > 0)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Lưu ý:</strong> Trình độ này đang được sử dụng bởi {{ $trinhDo->nhanSu->count() }} nhân viên. 
                                Việc thay đổi thông tin có thể ảnh hưởng đến dữ liệu nhân sự.
                            </div>
                        @endif
                        
                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('trinh-do.show', $trinhDo) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                                <a href="{{ route('trinh-do.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-list"></i> Danh sách
                                </a>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật trình độ
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
    $('#ten_trinh_do').focus();
    
    // Xác nhận trước khi submit
    $('form').on('submit', function(e) {
        if (!confirm('Bạn có chắc chắn muốn cập nhật trình độ này?')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection