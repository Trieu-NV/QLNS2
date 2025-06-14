@extends('layouts.app')

@section('title', 'Danh sách nhân sự')
@section('page-title', 'Quản lý nhân sự')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Danh sách nhân sự</h5>
        <a href="{{ route('nhan-su.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Thêm nhân sự
        </a>
    </div>
    
    <div class="card-body">
        <!-- Bộ lọc và tìm kiếm -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Bộ lọc và tìm kiếm</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('nhan-su.index') }}" id="searchForm">
                    <div class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label">Tìm kiếm</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Tìm theo tên, mã NV, SĐT..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Chức vụ</label>
                            <select name="chuc_vu" class="form-select">
                                <option value="">Tất cả chức vụ</option>
                                @foreach($chucVus as $chucVu)
                                    <option value="{{ $chucVu->id }}" {{ request('chuc_vu') == $chucVu->id ? 'selected' : '' }}>
                                        {{ $chucVu->ten_chuc_vu }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Phòng ban</label>
                            <select name="phong_ban" class="form-select">
                                <option value="">Tất cả phòng ban</option>
                                @foreach($phongBans as $phongBan)
                                    <option value="{{ $phongBan->id }}" {{ request('phong_ban') == $phongBan->id ? 'selected' : '' }}>
                                        {{ $phongBan->ten_phong_ban }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Trình độ</label>
                            <select name="trinh_do" class="form-select">
                                <option value="">Tất cả trình độ</option>
                                @foreach($trinhDos as $trinhDo)
                                    <option value="{{ $trinhDo->id }}" {{ request('trinh_do') == $trinhDo->id ? 'selected' : '' }}>
                                        {{ $trinhDo->ten_trinh_do }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Sắp xếp theo</label>
                            <select name="sort_by" class="form-select">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                                <option value="ho_ten" {{ request('sort_by') == 'ho_ten' ? 'selected' : '' }}>Họ tên</option>
                                <option value="ma_nv" {{ request('sort_by') == 'ma_nv' ? 'selected' : '' }}>Mã NV</option>
                                <option value="ngay_sinh" {{ request('sort_by') == 'ngay_sinh' ? 'selected' : '' }}>Ngày sinh</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label">Thứ tự</label>
                            <select name="sort_order" class="form-select">
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                            </select>
                        </div>
                        <div class="col-lg-10 col-md-6 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-2"></i>Tìm kiếm
                            </button>
                            <a href="{{ route('nhan-su.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-refresh me-2"></i>Làm mới
                            </a>
                            <button type="button" class="btn btn-outline-info" onclick="toggleAdvancedSearch()">
                                <i class="fas fa-cog me-2"></i>Nâng cao
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Bảng danh sách -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-table me-2"></i>Danh sách nhân sự</h6>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary me-2">{{ $nhanSu->total() }} nhân sự</span>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="exportData('excel')" title="Xuất Excel">
                            <i class="fas fa-file-excel"></i>
                            <span>Xuất Excel</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="exportData('pdf')" title="Xuất PDF">
                            <i class="fas fa-file-pdf"></i>
                            <span>Xuất PDF</span>
                        </button>
                       
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 100px;">Mã NV</th>
                                <th>Họ tên</th>
                                <th class="text-center" style="width: 60px;">Ảnh</th>
                                <th class="text-center" style="width: 80px;">Giới tính</th>
                                <th style="width: 110px;">Ngày sinh</th>
                                <th style="width: 120px;">SĐT</th>
                                <th>Chức vụ</th>
                                <th>Phòng ban</th>
                                <th>Trình độ</th>
                                <th class="text-center" style="width: 100px;">Trạng thái</th>
                                <th class="text-center" style="width: 120px;">Thao tác</th>
                            </tr>
                        </thead>
                <tbody>
                    @forelse($nhanSu as $item)
                        <tr>
                            
                            <td><strong>{{ $item->ma_nv }}</strong></td>
                            <td>{{ $item->ho_ten }}</td>
                            <td>
                                @if($item->hinh_anh)
                                    <img src="{{ asset('storage/' . $item->hinh_anh) }}" alt="Avatar" class="avatar">
                                @else
                                    <div class="avatar bg-secondary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($item->gioi_tinh == 'Nam')
                                    <span class="badge bg-primary">{{ $item->gioi_tinh }}</span>
                                @elseif($item->gioi_tinh == 'Nữ')
                                    <span class="badge bg-danger">{{ $item->gioi_tinh }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $item->gioi_tinh }}</span>
                                @endif
                            </td>
                            <td>{{ $item->ngay_sinh->format('d/m/Y') }}</td>
                            <td>{{ $item->sdt ?? 'N/A' }}</td>
                            <td>{{ $item->chucVu->ten_chuc_vu ?? 'N/A' }}</td>
                            <td>{{ $item->phongBan->ten_phong_ban ?? 'N/A' }}</td>
                            <td>{{ $item->trinhDo->ten_trinh_do ?? 'N/A' }}</td>
                            <td>
                                @if($item->trang_thai)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-warning">Tạm dừng</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    @if($item)
                                         <a href="{{ route('nhan-su.show', $item->ma_nv) }}" class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                             <i class="fas fa-eye"></i>
                                         </a>
                                     @else
                                         <button class="btn btn-sm btn-outline-info" disabled title="Không có thông tin chi tiết">
                                             <i class="fas fa-eye"></i>
                                         </button>
                                     @endif
                                    <a href="{{ route('nhan-su.edit', $item->ma_nv) }}" class="btn btn-sm btn-outline-warning" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Xóa" 
                                            onclick="confirmDelete('{{ $item->ma_nv }}', '{{ $item->ho_ten }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted mb-2">Không có dữ liệu nhân sự</h5>
                                    <p class="text-muted mb-3">Chưa có nhân sự nào trong hệ thống</p>
                                    <a href="{{ route('nhan-su.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Thêm nhân sự đầu tiên
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Thông tin và Phân trang -->
        <!-- <div class="row mt-4">
            <div class="col-md-6">
                <div class="d-flex align-items-center text-muted">
                    <i class="fas fa-info-circle me-2"></i>
                    <span>Hiển thị {{ $nhanSu->firstItem() ?? 0 }} - {{ $nhanSu->lastItem() ?? 0 }} trong tổng số {{ $nhanSu->total() }} nhân sự</span>
                </div>
            </div>
            <div class="col-md-6">
                @if($nhanSu->hasPages())
                    <div class="d-flex justify-content-end">
                        {{ $nhanSu->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div> -->
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa nhân sự <strong id="deleteName"></strong>?</p>
                <p class="text-danger"><small>Hành động này không thể hoàn tác!</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteForm').action = '/nhan-su/' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function toggleAdvancedSearch() {
    // Placeholder for advanced search functionality
    alert('Tính năng tìm kiếm nâng cao sẽ được phát triển trong phiên bản tiếp theo!');
}

function exportData(type) {
    if (type === 'excel') {
        // Lấy các tham số filter hiện tại
        const form = document.getElementById('searchForm');
        const formData = new FormData(form);
        const params = new URLSearchParams();
        
        // Thêm các tham số từ form vào URL
        for (let [key, value] of formData.entries()) {
            if (value) {
                params.append(key, value);
            }
        }
        
        // Tạo URL export với các tham số filter
        const exportUrl = '{{ route("nhan-su.export.excel") }}' + (params.toString() ? '?' + params.toString() : '');
        
        // Mở link download trong tab mới
        window.open(exportUrl, '_blank');
    } else if (type === 'pdf') {
        const form = document.getElementById('searchForm');
        const formData = new FormData(form);
        const params = new URLSearchParams();
        
        for (let [key, value] of formData.entries()) {
            if (value) {
                params.append(key, value);
            }
        }
        
        const exportUrl = '{{ route("nhan-su.export.pdf") }}' + (params.toString() ? '?' + params.toString() : '');
        
        window.open(exportUrl, '_blank');
    }
}



// Auto-submit form when filters change
$(document).ready(function() {
    $('.form-select').on('change', function() {
        if ($(this).attr('name') !== 'sort_by' && $(this).attr('name') !== 'sort_order') {
            // Auto-submit for filter changes (optional)
            // $('#searchForm').submit();
        }
    });
    
    // Add loading state to search button
    $('#searchForm').on('submit', function() {
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin me-2"></i>Đang tìm kiếm...');
    });
    
    // Enhance table hover effects
    $('.table tbody tr').hover(
        function() {
            $(this).addClass('table-active');
        },
        function() {
            $(this).removeClass('table-active');
        }
    );
});
</script>
@endpush