@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi Tiết Phụ Cấp</h1>
    <div class="card">
        <div class="card-header">
            Thông tin phụ cấp: {{ $phuCap->phu_cap_name }}
        </div>
        <div class="card-body">
            <p><strong>Tên Phụ Cấp:</strong> {{ $phuCap->phu_cap_name }}</p>
            <p><strong>Số Tiền:</strong> {{ number_format($phuCap['so-tien'], 0, ',', '.') }} VNĐ</p>
            <p><strong>Mô Tả:</strong> {{ $phuCap['mo-ta'] }}</p>
        </div>
    </div>
    <a href="{{ route('phu-cap.index') }}" class="btn btn-primary mt-3">Quay lại</a>
</div>
@endsection