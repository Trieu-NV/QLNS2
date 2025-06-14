@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Bảng Chấm Công - {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('cham-cong.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search_ten_nv" class="form-control" placeholder="Tìm theo tên nhân viên" value="{{ request('search_ten_nv') }}">
            </div>
            <div class="col-md-3">
                <select name="phong_ban_id" class="form-control">
                    <option value="">-- Lọc theo phòng ban --</option>
                    @foreach($phongBans as $phongBan)
                        <option value="{{ $phongBan->id }}" {{ request('phong_ban_id') == $phongBan->id ? 'selected' : '' }}>
                            {{ $phongBan->ten_phong_ban }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="thead-light">
            <tr>
                <th>STT</th>
                <th>Mã NV</th>
                <th>Họ Tên</th>
                <th>Phòng Ban</th>
                <th>Ngày</th>
                <th>Trạng Thái</th>
                <th>Ghi Chú</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($chamCongs as $key => $chamCong)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $chamCong->nhanSu->ma_nv }}</td>
                    <td>{{ $chamCong->nhanSu->ho_ten }}</td>
                    <td>{{ $chamCong->nhanSu->phongBan->ten_phong_ban ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($chamCong->ngay)->format('d/m/Y') }}</td>
                    <td id="trang_thai_{{ $chamCong->id }}">
                        <span >
                            {{ $chamCong->trang_thai }}
                        </span>
                    </td>
                    <td id="ghi_chu_{{ $chamCong->id }}">{{ $chamCong->ghi_chu }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info mr-1 direct-cham-cong-btn" data-id="{{ $chamCong->id }}">
                            Chấm Công
                        </button>
                        <button type="button" class="btn btn-sm btn-warning mr-1" data-bs-toggle="modal" data-bs-target="#nghiModal{{ $chamCong->id }}">
                            Nghỉ
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#phepModal{{ $chamCong->id }}">
                            Phép
                        </button>
                    </td>
                </tr>


                <!-- Modal Nghỉ -->
                <div class="modal fade" id="nghiModal{{ $chamCong->id }}" tabindex="-1" role="dialog" aria-labelledby="nghiModalLabel{{ $chamCong->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form class="cham-cong-form" data-id="{{ $chamCong->id }}" method="POST" action="{{ route('cham-cong.update', $chamCong->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="nghiModalLabel{{ $chamCong->id }}">Đăng Ký Nghỉ: {{ $chamCong->nhanSu->ho_ten }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Nhân viên:</strong> {{ $chamCong->nhanSu->ho_ten }}</p>
                                    <p><strong>Ngày:</strong> {{ \Carbon\Carbon::parse($chamCong->ngay)->format('d/m/Y') }}</p>
                                    <input type="hidden" name="trang_thai" value="Nghỉ">
                                    <div class="form-group">
                                        <label for="loai_nghi_{{ $chamCong->id }}">Lý do nghỉ:</label>
                                        <select name="loai_nghi" id="loai_nghi_{{ $chamCong->id }}" class="form-control">
                                            <option value="Nghỉ Ốm">Nghỉ Ốm</option>
                                            <option value="Nghỉ Không Lương">Nghỉ Không Lương</option>
                                            <option value="Khác">Khác</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ghi_chu_nghi_{{ $chamCong->id }}">Ghi chú thêm:</label>
                                        <textarea name="ghi_chu" id="ghi_chu_nghi_{{ $chamCong->id }}" class="form-control">{{ old('ghi_chu') }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Phép -->
                <div class="modal fade" id="phepModal{{ $chamCong->id }}" tabindex="-1" role="dialog" aria-labelledby="phepModalLabel{{ $chamCong->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form class="cham-cong-form" data-id="{{ $chamCong->id }}" method="POST" action="{{ route('cham-cong.update', $chamCong->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="phepModalLabel{{ $chamCong->id }}">Đăng Ký Phép: {{ $chamCong->nhanSu->ho_ten }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Nhân viên:</strong> {{ $chamCong->nhanSu->ho_ten }}</p>
                                    <p><strong>Ngày:</strong> {{ \Carbon\Carbon::parse($chamCong->ngay)->format('d/m/Y') }}</p>
                                    <input type="hidden" name="trang_thai" value="Phép">
                                    <div class="form-group">
                                        <label for="loai_phep_{{ $chamCong->id }}">Loại phép:</label>
                                        <select name="loai_phep" id="loai_phep_{{ $chamCong->id }}" class="form-control">
                                            <option value="Phép năm">Phép năm</option>
                                            <option value="Cưới">Cưới</option>
                                            <option value="Phép Chế Độ Khác">Phép Chế Độ Khác</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ghi_chu_phep_{{ $chamCong->id }}">Ghi chú thêm:</label>
                                        <textarea name="ghi_chu" id="ghi_chu_phep_{{ $chamCong->id }}" class="form-control">{{ old('ghi_chu') }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-primary">Đăng Ký Phép</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @empty
                <tr>
                    <td colspan="7" class="text-center">Không có dữ liệu chấm công cho ngày hôm nay.</td>
                </tr>
            @endforelse
        </tbody>
    </table>



</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.cham-cong-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var formData = form.serialize();
            var chamCongId = form.data('id');

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Update the table row with new data
                        $('#trang_thai_' + chamCongId).html('<span >' + response.trang_thai + '</span>');
                        $('#ghi_chu_' + chamCongId).text(response.ghi_chu);

                        // Close the modal
                        form.closest('.modal').modal('hide');

                        // Optionally, show a success message
                        // alert(response.message);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        });

        // Handle direct Chấm Công button click
        $('.direct-cham-cong-btn').on('click', function() {
            var chamCongId = $(this).data('id');
            var url = '{{ route('cham-cong.update', ':id') }}';
            url = url.replace(':id', chamCongId);

            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    trang_thai: 'Đi Làm',
                    ghi_chu: ''
                },
                success: function(response) {
                    if (response.success) {
                        $('#trang_thai_' + chamCongId).html('<span >' + response.trang_thai + '</span>');
                        $('#ghi_chu_' + chamCongId).text(response.ghi_chu);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('An error occurred: ' + xhr.responseText);
                }
            });
        });
    });
</script>
@endpush
