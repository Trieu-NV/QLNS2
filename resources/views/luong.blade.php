@extends('layouts.app')

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Bảng Lương Nhân Viên</h1>

        <form action="{{ route('luong.report') }}" method="GET" class="mb-4">
            <div class="form-row d-flex gap-3">
                <div class="col-md-3">
                    <label for="month">Tháng:</label>
                    <input type="number" id="month" name="month" class="form-control" value="{{ $month }}" min="1" max="12">
                </div>
                <div class="col-md-3">
                    <label for="year">Năm:</label>
                    <input type="number" id="year" name="year" class="form-control" value="{{ $year }}" min="2000" max="2100">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Xem Báo Cáo</button>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <a href="{{ route('luong.export', ['month' => $month, 'year' => $year]) }}" class="btn btn-success">Xuất Excel</a>
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
                        <td>{{ number_format($data['tong_luong'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection