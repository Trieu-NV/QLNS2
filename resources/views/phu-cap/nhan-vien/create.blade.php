@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thêm mới Nhân viên - Phụ cấp</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('nhan-vien-phu-cap.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="ma_nv" class="form-label">Nhân viên</label>
                <select class="form-control" id="ma_nv" name="ma_nv" required>
                    <option value="">Chọn nhân viên</option>
                    @foreach ($nhanSus as $nhanSu)
                        <option value="{{ $nhanSu->ma_nv }}" {{ old('ma_nv') == $nhanSu->ma_nv ? 'selected' : '' }}>
                            {{ $nhanSu->ma_nv }} - {{ $nhanSu->ho_ten }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="id_phu_cap" class="form-label">Phụ cấp</label>
                <select class="form-control" id="id_phu_cap" name="id_phu_cap" required>
                    <option value="">Chọn phụ cấp</option>
                    @foreach ($phuCaps as $phuCap)
                        <option value="{{ $phuCap->id }}" {{ old('id_phu_cap') == $phuCap->id ? 'selected' : '' }}>
                            {{ $phuCap->phu_cap_name }} ({{ number_format($phuCap->{'so-tien'}, 0, ',', '.') }} VNĐ)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="ghi_chu" class="form-label">Ghi chú</label>
                <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="3">{{ old('ghi_chu') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('nhan-vien-phu-cap.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection