@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Bảng Lương Nhân Viên</h1>

        <form action="{{ route('luong.report') }}" method="GET" class="mb-4">
            <div class="form-row d-flex gap-3">
                <div class="col-md-1">
                    <label for="month">Tháng:</label>
                    <input type="number" id="month" name="month" class="form-control" value="{{ $month }}" min="1" max="12">
                </div>
                <div class="col-md-1">
                    <label for="year">Năm:</label>
                    <input type="number" id="year" name="year" class="form-control" value="{{ $year }}" min="2000" max="2100">
                </div>
                <div class="col-md-2">
                    <label for="phong_ban">Phòng ban:</label>
                    <select name="phong_ban" id="phong_ban" class="form-select">
                        <option value="">Tất cả phòng ban</option>
                        @foreach($phongBans as $pb)
                            <option value="{{ $pb->id }}" {{ (request('phong_ban', $phongBanId ?? '') == $pb->id) ? 'selected' : '' }}>{{ $pb->ten_phong_ban }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="sort_by">Sắp xếp theo:</label>
                    <select name="sort_by" id="sort_by" class="form-select">
                        <option value="tong_luong" {{ (request('sort_by', $sortBy ?? '') == 'tong_luong') ? 'selected' : '' }}>Tổng lương</option>
                        <option value="luong_co_ban" {{ (request('sort_by', $sortBy ?? '') == 'luong_co_ban') ? 'selected' : '' }}>Lương cơ bản</option>
                        <option value="phu_cap" {{ (request('sort_by', $sortBy ?? '') == 'phu_cap') ? 'selected' : '' }}>Phụ cấp</option>
                        <option value="tien_thuong" {{ (request('sort_by', $sortBy ?? '') == 'tien_thuong') ? 'selected' : '' }}>Tiền thưởng</option>
                        <option value="tien_phat" {{ (request('sort_by', $sortBy ?? '') == 'tien_phat') ? 'selected' : '' }}>Tiền phạt</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="sort_order">Thứ tự:</label>
                    <select name="sort_order" id="sort_order" class="form-select">
                        <option value="desc" {{ (request('sort_order', $sortOrder ?? '') == 'desc') ? 'selected' : '' }}>Giảm dần</option>
                        <option value="asc" {{ (request('sort_order', $sortOrder ?? '') == 'asc') ? 'selected' : '' }}>Tăng dần</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Xem Báo Cáo</button>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <a href="{{ route('luong.export', array_merge(request()->all(), ['month' => $month, 'year' => $year])) }}" class="btn btn-success w-100">Xuất Excel</a>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã NV</th>
                    <th>Họ Tên</th>
                    <th>Phòng Ban</th>
                    <th>Lương Cơ Bản</th>
                    <th>Phụ Cấp</th>
                    <th>Tiền Thưởng</th>
                    <th>Tiền Phạt</th>
                    <th>Số Ngày Nghỉ</th>
                    <th>Bảo hiểm NV đóng</th>
                    <th>Tổng Lương</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salaryData as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data['ma_nv'] }}</td>
                        <td>{{ $data['ho_ten'] }}</td>
                        <td>{{ $data['phong_ban'] }}</td>
                        <td>{{ number_format($data['luong_co_ban'], 0, ',', '.') }}</td>
                        <td>{{ number_format($data['phu_cap'], 0, ',', '.') }}</td>
                        <td>{{ number_format($data['tien_thuong'], 0, ',', '.') }}</td>
                        <td>{{ number_format($data['tien_phat'], 0, ',', '.') }}</td>
                        <td>{{ $data['so_ngay_nghi'] }}</td>
                        <td>{{ number_format($data['bao_hiem_nv'], 0, ',', '.') }}</td>
                        <td>{{ number_format($data['tong_luong'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection