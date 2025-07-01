@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h1 mb-4">Danh sách Bảo hiểm Y tế</h1>
    <div class="box-func d-flex justify-content-between">
        <!-- form tìm kiếm -->
        <form action="" method="GET" class="form-inline d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm bảo hiểm y tế" value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-primary btn-search">Tìm kiếm</button>
        </form>
            <a href="{{ route('bao-hiem-yte.create') }}" class="btn btn-primary btn-add d-flex ">Thêm Bảo hiểm Y tế</a>
       
    </div>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th><a href="{{ route('bao-hiem-yte.index', array_merge(request()->query(), ['sort_by' => 'idbh', 'sort_order' => (request('sort_by') == 'idbh' && request('sort_order') == 'asc' ? 'desc' : 'asc')])) }}">Mã BH</a></th>
                <th><a href="{{ route('bao-hiem-yte.index', array_merge(request()->query(), ['sort_by' => 'ma_nv', 'sort_order' => (request('sort_by') == 'ma_nv' && request('sort_order') == 'asc' ? 'desc' : 'asc')])) }}">Mã NV</a></th>
                <th><a href="{{ route('bao-hiem-yte.index', array_merge(request()->query(), ['sort_by' => 'so_bao_hiem', 'sort_order' => (request('sort_by') == 'so_bao_hiem' && request('sort_order') == 'asc' ? 'desc' : 'asc')])) }}">Số Bảo Hiểm</a></th>
                <th><a href="{{ route('bao-hiem-yte.index', array_merge(request()->query(), ['sort_by' => 'ngay_cap', 'sort_order' => (request('sort_by') == 'ngay_cap' && request('sort_order') == 'asc' ? 'desc' : 'asc')])) }}">Ngày Cấp</a></th>
                <th><a href="{{ route('bao-hiem-yte.index', array_merge(request()->query(), ['sort_by' => 'noi_cap', 'sort_order' => (request('sort_by') == 'noi_cap' && request('sort_order') == 'asc' ? 'desc' : 'asc')])) }}">Nơi Cấp</a></th>
                <th><a href="{{ route('bao-hiem-yte.index', array_merge(request()->query(), ['sort_by' => 'noi_kham_benh', 'sort_order' => (request('sort_by') == 'noi_kham_benh' && request('sort_order') == 'asc' ? 'desc' : 'asc')])) }}">Nơi Khám Bệnh</a></th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($baoHiemYtes as $key => $baoHiemYte)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $baoHiemYte->idbh }}</td>
                    <td>{{ $baoHiemYte->ma_nv }}</td>
                    <td>{{ $baoHiemYte->so_bao_hiem }}</td>
                    <td>{{ \Carbon\Carbon::parse($baoHiemYte->ngay_cap)->format('d/m/Y') }}</td>
                    <td>{{ $baoHiemYte->noi_cap }}</td>
                    <td>{{ $baoHiemYte->noi_kham_benh }}</td>
                    <td>
                        <a href="{{ route('bao-hiem-yte.edit', $baoHiemYte->idbh) }}" class="btn btn-warning">Sửa</a>
                        <button type="button" class="btn btn-danger" 
                            onclick="showDeleteModal('{{ $baoHiemYte->idbh }}', '{{ $baoHiemYte->so_bao_hiem }}')">
                        Xoá
                    </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
   
    <!-- Single Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa bảo hiểm y tế số "<span id="deleteBaoHiemYteSoBaoHiem"></span>" không?
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
function showDeleteModal(idbh, soBaoHiem) {
    document.getElementById('deleteBaoHiemYteSoBaoHiem').textContent = soBaoHiem;
    document.getElementById('deleteForm').action = `/bao-hiem-yte/${idbh}`;
    
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