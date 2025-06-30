@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Bảo Hiểm Xã Hội Tháng {{ \Carbon\Carbon::parse($thang_nam.'-01')->format('m/Y') }}</h1>
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên" value="{{ request('search', $search ?? '') }}">
        </div>
        <div class="col-md-4">
            <select name="phong_ban" class="form-select">
                <option value="">-- Tất cả phòng ban --</option>
                @foreach($phongBans as $pb)
                    <option value="{{ $pb->id }}" {{ (request('phong_ban', $phong_ban ?? '') == $pb->id) ? 'selected' : '' }}>{{ $pb->ten_phong_ban }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Lọc</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('bao-hiem-xa-hoi.index') }}" class="btn btn-secondary w-100">Đặt lại</a>
        </div>
    </form>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã NV</th>
                <th>Họ Tên</th>
                <th>Lương cơ bản</th>
                <th>BHXH NV</th>
                <th>BHYT NV</th>
                <th>BHTN NV</th>
                <th>Tổng NV</th>
                <th>BHXH DN</th>
                <th>BHYT DN</th>
                <th>BHTN DN</th>
                <th>KPCĐ</th>
                <th>Tổng DN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dsBaoHiem as $i => $row)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $row['nhan_su']->ma_nv }}</td>
                    <td>{{ $row['nhan_su']->ho_ten }}</td>
                    <td>{{ number_format($row['luong']) }}</td>
                    <td>{{ number_format($row['bhxh_nv']) }}</td>
                    <td>{{ number_format($row['bhyt_nv']) }}</td>
                    <td>{{ number_format($row['bhtn_nv']) }}</td>
                    <td>{{ number_format($row['tong_nv']) }}</td>
                    <td>{{ number_format($row['bhxh_dn']) }}</td>
                    <td>{{ number_format($row['bhyt_dn']) }}</td>
                    <td>{{ number_format($row['bhtn_dn']) }}</td>
                    <td>{{ number_format($row['kinh_phi_cong_doan']) }}</td>
                    <td>{{ number_format($row['tong_dn']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 