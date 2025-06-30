@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Bảo Hiểm Xã Hội Tháng {{ \Carbon\Carbon::parse($thang_nam.'-01')->format('m/Y') }}</h1>
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