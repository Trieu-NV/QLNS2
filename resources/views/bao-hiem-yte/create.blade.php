@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Thêm Bảo hiểm Y tế Mới</h1>
    <form action="{{ route('bao-hiem-yte.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="idbh">Mã Bảo hiểm:</label>
            <input type="text" class="form-control" id="idbh" name="idbh" value="{{ old('idbh') }}" required>
            @error('idbh')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="ma_nv">Mã Nhân viên:</label>
            <input type="text" class="form-control" id="ma_nv" name="ma_nv" value="{{ old('ma_nv') }}" required>
            @error('ma_nv')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="so_bao_hiem">Số Bảo hiểm:</label>
            <input type="text" class="form-control" id="so_bao_hiem" name="so_bao_hiem" value="{{ old('so_bao_hiem') }}" required maxlength="10">
            @error('so_bao_hiem')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="ngay_cap">Ngày Cấp:</label>
            <input type="date" class="form-control" id="ngay_cap" name="ngay_cap" value="{{ old('ngay_cap') }}" required>
            @error('ngay_cap')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="noi_cap">Nơi Cấp:</label>
            <input type="text" class="form-control" id="noi_cap" name="noi_cap" value="{{ old('noi_cap') }}" required>
            @error('noi_cap')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="noi_kham_benh">Nơi Khám Bệnh:</label>
            <input type="text" class="form-control" id="noi_kham_benh" name="noi_kham_benh" value="{{ old('noi_kham_benh') }}" required>
            @error('noi_kham_benh')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="{{ route('bao-hiem-yte.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection