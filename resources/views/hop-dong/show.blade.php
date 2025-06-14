@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết Hợp đồng</h1>

    <div class="card">
        <div class="card-header">Thông tin Hợp đồng {{ $hopDong->id }}</div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $hopDong->id }}</p>
            <p><strong>Mã Nhân viên:</strong> {{ $hopDong->ma_nv }}</p>
            <p><strong>Tên Nhân viên:</strong> {{ $hopDong->nhanSu->ho_ten ?? 'N/A' }}</p>
            <p><strong>Loại Hợp đồng:</strong> {{ $hopDong->loai_hop_dong_text }}</p>
            <p><strong>Lương:</strong> {{ number_format($hopDong->luong) }}</p>
            <p><strong>Ngày Bắt đầu:</strong> {{ \Carbon\Carbon::parse($hopDong->ngay_bat_dau)->format('d/m/Y') }}</p>
            <p><strong>Ngày Kết thúc:</strong> {{ $hopDong->ngay_ket_thuc ? \Carbon\Carbon::parse($hopDong->ngay_ket_thuc)->format('d/m/Y') : 'N/A' }}</p>
            <p><strong>Ngày Ký:</strong> {{ \Carbon\Carbon::parse($hopDong->ngay_ky)->format('d/m/Y') }}</p>
            <p><strong>Số lần Ký:</strong> {{ $hopDong->so_lan_ky }}</p>
        </div>
    </div>

    <a href="{{ route('hop-dong.index') }}" class="btn btn-primary mt-3">Quay lại Danh sách</a>
    <a href="{{ route('hop-dong.edit', $hopDong->id) }}" class="btn btn-warning mt-3">Chỉnh sửa</a>
</div>
@endsection