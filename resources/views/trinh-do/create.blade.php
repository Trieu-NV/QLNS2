@extends('layouts.app')

@section('title', 'Thêm Trình độ mới')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-plus"></i> Thêm Trình độ mới
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('trinh-do.store') }}" method="POST">
                        @csrf
                        
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
                                           value="{{ old('ten_trinh_do') }}"
                                           placeholder="Nhập tên trình độ"
                                           required>
                                    @error('ten_trinh_do')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
                                      placeholder="Nhập mô tả về trình độ (không bắt buộc)">{{ old('mo_ta') }}</textarea>
                            @error('mo_ta')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('trinh-do.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu trình độ
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
        if (!confirm('Bạn có chắc chắn muốn thêm trình độ này?')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection