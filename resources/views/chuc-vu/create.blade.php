@extends('layouts.app')

@section('title', 'Thêm Chức vụ mới')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-plus"></i> Thêm Chức vụ mới
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('chuc-vu.store') }}" method="POST">
                        @csrf
                        
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
                                           value="{{ old('ten_chuc_vu') }}"
                                           placeholder="Nhập tên chức vụ"
                                           required>
                                    @error('ten_chuc_vu')
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
                                      placeholder="Nhập mô tả về chức vụ (không bắt buộc)">{{ old('mo_ta') }}</textarea>
                            @error('mo_ta')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('chuc-vu.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu chức vụ
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
        if (!confirm('Bạn có chắc chắn muốn thêm chức vụ này?')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection