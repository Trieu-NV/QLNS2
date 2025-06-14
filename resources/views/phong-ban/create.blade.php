@extends('layouts.app')

@section('title', 'Thêm Phòng ban mới')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-plus"></i> Thêm Phòng ban mới
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('phong-ban.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Tên phòng ban -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ten_phong_ban" class="form-label">
                                        <i class="fas fa-building"></i> Tên phòng ban <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('ten_phong_ban') is-invalid @enderror" 
                                           id="ten_phong_ban" 
                                           name="ten_phong_ban" 
                                           value="{{ old('ten_phong_ban') }}"
                                           placeholder="Nhập tên phòng ban"
                                           required>
                                    @error('ten_phong_ban')
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
                                      placeholder="Nhập mô tả về phòng ban (không bắt buộc)">{{ old('mo_ta') }}</textarea>
                            @error('mo_ta')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('phong-ban.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu phòng ban
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
    $('#ten_phong_ban').focus();
    
    // Xác nhận trước khi submit
    $('form').on('submit', function(e) {
        if (!confirm('Bạn có chắc chắn muốn thêm phòng ban này?')) {
            e.preventDefault();
        }
    });
});
</script>
@endsection