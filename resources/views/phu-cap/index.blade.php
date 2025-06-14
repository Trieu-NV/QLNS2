@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="h1 mb-4">Danh sách phụ cấp</h1>
    <div class="box-func d-flex justify-content-between">
        <!-- form tìm kiếm -->
        <form action="" method="GET" class="form-inline d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm phụ cấp" value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-primary btn-search">Tìm kiếm</button>
        </form>
            <a href="{{ route('phu-cap.create') }}" class="btn btn-primary btn-add d-flex ">Thêm Phụ cấp</a>
       
    </div>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th><a href="{{ route('phu-cap.index', array_merge(request()->query(), ['sort_by' => 'phu_cap_name', 'sort_order' => (request('sort_by') == 'phu_cap_name' && request('sort_order') == 'asc' ? 'desc' : 'asc')])) }}">Tên phụ cấp</a></th>
                <th><a href="{{ route('phu-cap.index', array_merge(request()->query(), ['sort_by' => 'so-tien', 'sort_order' => (request('sort_by') == 'so-tien' && request('sort_order') == 'asc' ? 'desc' : 'asc')])) }}">Số Tiền</a></th>
                <th><a href="{{ route('phu-cap.index', array_merge(request()->query(), ['sort_by' => 'mo-ta', 'sort_order' => (request('sort_by') == 'mo-ta' && request('sort_order') == 'asc' ? 'desc' : 'asc')])) }}">Mô tả</a></th>
                <th>Thao Tác</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($phuCaps as $key => $phuCap)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $phuCap->phu_cap_name }}</td>
                    <td>{{ number_format($phuCap['so-tien'], 0, ',', '.') }} VNĐ</td>
                    <td>{{ $phuCap['mo-ta'] ? $phuCap['mo-ta'] : 'Chưa có mô tả' }}</td>
                    <td>
                        <a href="{{ route('phu-cap.edit', $phuCap->id) }}" class="btn btn-warning">Sửa</a>
                       <button type="button" class="btn btn-danger" 
                            onclick="showDeleteModal('{{ $phuCap->id }}', '{{ $phuCap->ten_phu_cap }}')">
                        Xoá
                    </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $phuCaps->links() }}
    </div>
    <!-- Single Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa phụ cấp "<span id="deletePhuCapName"></span>" không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
function showDeleteModal(id, name) {
    document.getElementById('deletePhuCapName').textContent = name;
    document.getElementById('deleteForm').action = `/phu-cap/${id}`;
    
    let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush
@endsection
<style>
    .box-func{
        width: 100%;
        height: 40px;
        margin-bottom: 20px;
    }
    .btn-search{
        height: 100%;
        white-space: nowrap;
    }
    .btn-add{
        height: 100%;
        align-items: center;
    }
    
</style>