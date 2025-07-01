@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách Hợp đồng</h1>


    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="d-flex justify-content-between row mb-3">
        <form action="{{ route('hop-dong.index') }}" method="GET" class="col-md-10 row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo mã nhân viên hoặc tên nhân viên..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="loai_hop_dong" class="form-control">
                    <option value="">-- Loại hợp đồng --</option>
                    <option value="1" {{ request('loai_hop_dong') == '1' ? 'selected' : '' }}>Hợp đồng xác định thời hạn</option>
                    <option value="2" {{ request('loai_hop_dong') == '2' ? 'selected' : '' }}>Hợp đồng không xác định thời hạn</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="ngay_bat_dau" class="form-control" value="{{ request('ngay_bat_dau') }}" placeholder="Ngày bắt đầu">
            </div>
            <div class="col-md-2">
                <input type="date" name="ngay_ket_thuc" class="form-control" value="{{ request('ngay_ket_thuc') }}" placeholder="Ngày kết thúc">
            </div>
            <div class="col-md-2">
                <select name="trang_thai" class="form-control">
                    <option value="">-- Trạng thái nhân sự --</option>
                    <option value="1" {{ request('trang_thai') == '1' ? 'selected' : '' }}>Đang làm</option>
                    <option value="0" {{ request('trang_thai') == '0' ? 'selected' : '' }}>Đã nghỉ</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-outline-secondary w-100">Lọc</button>
            </div>
        </form>
        <a href="{{ route('hop-dong.create') }}" class="btn btn-primary col-md-2 d-flex justify-content-center align-items-center">Thêm Hợp đồng mới</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Mã NV</th>
                <th>Tên NV</th>
                <th>Loại Hợp đồng</th>
                <th>
                    <a href="{{ route('hop-dong.index', array_merge(request()->except('page'), ['sort' => request('sort') === 'luong_asc' ? 'luong_desc' : 'luong_asc'])) }}">
                        Lương
                        @if(request('sort') === 'luong_asc')
                            <span>&uarr;</span>
                        @elseif(request('sort') === 'luong_desc')
                            <span>&darr;</span>
                        @endif
                    </a>
                </th>
                <th>Ngày Bắt đầu</th>
                <th>Ngày Kết thúc</th>
                <th>Ngày Ký</th>
                <th>Số lần Ký</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hopDongs as $index => $hopDong)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $hopDong->ma_nv }}</td>
                <td>{{ $hopDong->nhanSu->ho_ten ?? 'N/A' }}</td>
                <td>{{ $hopDong->loai_hop_dong_text }}</td>
                <td>{{ number_format($hopDong->luong) }}</td>
                <td>{{ \Carbon\Carbon::parse($hopDong->ngay_bat_dau)->format('d/m/Y') }}</td>
                <td>{{ $hopDong->ngay_ket_thuc ? \Carbon\Carbon::parse($hopDong->ngay_ket_thuc)->format('d/m/Y') : 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($hopDong->ngay_ky)->format('d/m/Y') }}</td>
                <td>{{ $hopDong->so_lan_ky }}</td>
                <td>
                    <a href="{{ route('hop-dong.show', $hopDong->id) }}" class="btn btn-info btn-sm">Xem</a>
                    <a href="{{ route('hop-dong.edit', $hopDong->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('hop-dong.destroy', $hopDong->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa hợp đồng này không?');">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection