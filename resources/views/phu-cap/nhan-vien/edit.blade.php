@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chỉnh sửa Nhân viên - Phụ cấp</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('nhan-vien-phu-cap.update', ['ma_nv' => $nhanVienPhuCap->ma_nv, 'id_phu_cap' => $nhanVienPhuCap->id_phu_cap]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="ma_nv" class="form-label">Nhân viên</label>
                <input type="text" class="form-control" id="ma_nv_display" value="{{ $nhanVienPhuCap->nhanSu->ma_nv }} - {{ $nhanVienPhuCap->nhanSu->ho_ten }}" disabled>
                <input type="hidden" name="ma_nv" value="{{ $nhanVienPhuCap->ma_nv }}">
            </div>

            <div class="mb-3">
                <label for="id_phu_cap" class="form-label">Phụ cấp</label>
                <input type="text" class="form-control" id="id_phu_cap_display" value="{{ $nhanVienPhuCap->phuCap->phu_cap_name }} ({{ number_format($nhanVienPhuCap->phuCap->{'so-tien'}, 0, ',', '.') }} VNĐ)" disabled>
                <input type="hidden" name="id_phu_cap" value="{{ $nhanVienPhuCap->id_phu_cap }}">
            </div>

            <div class="mb-3">
                <label for="ghi_chu" class="form-label">Ghi chú</label>
                <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="3">{{ old('ghi_chu', $nhanVienPhuCap->ghi_chu) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('nhan-vien-phu-cap.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection