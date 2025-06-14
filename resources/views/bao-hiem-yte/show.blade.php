@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi Tiết Bảo hiểm Y tế</h1>
    <div class="card">
        <div class="card-header">
            Thông tin Bảo hiểm Y tế: {{ $baoHiemYte->so_bao_hiem }}
        </div>
        <div class="card-body">
            <p><strong>Mã Bảo hiểm:</strong> {{ $baoHiemYte->idbh }}</p>
            <p><strong>Mã Nhân viên:</strong> {{ $baoHiemYte->ma_nv }}</p>
            <p><strong>Số Bảo hiểm:</strong> {{ $baoHiemYte->so_bao_hiem }}</p>
            <p><strong>Ngày Cấp:</strong> {{ \Carbon\Carbon::parse($baoHiemYte->ngay_cap)->format('d/m/Y') }}</p>
            <p><strong>Nơi Cấp:</strong> {{ $baoHiemYte->noi_cap }}</p>
            <p><strong>Nơi Khám Bệnh:</strong> {{ $baoHiemYte->noi_kham_benh }}</p>
        </div>
    </div>
    <a href="{{ route('bao-hiem-yte.index') }}" class="btn btn-primary mt-3">Quay lại</a>
</div>
@endsection