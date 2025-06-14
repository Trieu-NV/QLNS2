@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h1 mb-4">Danh sách Nhân viên Phụ cấp</h1>

    <div class=" mb-3 d-flex justify-content-between">
        <div class="">
            <form action="{{ route('nhan-vien-phu-cap.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" style="width:280px" placeholder="Nhập tên nhân viên hoặc phụ cấp..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                </div>
            </form>
        </div>
        <div class="d-flex gap-3">
        <div class="">
            <a href="{{ route('nhan-vien-phu-cap.create') }}" class="btn btn-primary">Thêm Mới</a>
        </div>
        <div class=" ">
            <a class=" btn btn-primary" href="{{ route('phu-cap.index') }}">
                <span style="color: var(--bs-btn-color);">Danh Sách Phụ Cấp</span>
            </a>
        </div>
        </div>
       

    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã Nhân viên</th>
                <th>Tên Nhân viên</th>
                <th>Tên Phụ cấp</th>
                <th>Ghi chú</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($nhanVienPhuCaps as $item)
            <tr>
                <td>{{ $item->nhanSu->ma_nv }}</td>
                <td>{{ $item->nhanSu->ho_ten }}</td>
                <td>{{ $item->phuCap->phu_cap_name }}</td>
                <td>{{ $item->ghi_chu }}</td>
                <td>{{ $item->created_at->format('d/m/Y H:i:s') }}</td>
                <td>
                    <a href="{{ route('nhan-vien-phu-cap.edit', ['ma_nv' => $item->ma_nv, 'id_phu_cap' => $item->id_phu_cap]) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('nhan-vien-phu-cap.destroy', ['ma_nv' => $item->ma_nv, 'id_phu_cap' => $item->id_phu_cap]) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Không có dữ liệu</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $nhanVienPhuCaps->links() }}
</div>
@endsection