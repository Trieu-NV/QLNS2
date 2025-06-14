<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Danh sách Nhân sự</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>Danh sách Nhân sự</h1>
    <table>
        <thead>
            <tr>
                <th>Mã NV</th>
                <th>Họ Tên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>SĐT</th>
                <th>Chức vụ</th>
                <th>Phòng ban</th>
                <th>Trình độ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nhanSus as $nhanSu)
            <tr>
                <td>{{ $nhanSu->ma_nv }}</td>
                <td>{{ $nhanSu->ho_ten }}</td>
                <td>{{ $nhanSu->gioi_tinh }}</td>
                <td>{{ $nhanSu->ngay_sinh }}</td>
                <td>{{ $nhanSu->sdt }}</td>
                <td>{{ $nhanSu->chucVu->ten_chuc_vu ?? 'N/A' }}</td>
                <td>{{ $nhanSu->phongBan->ten_phong_ban ?? 'N/A' }}</td>
                <td>{{ $nhanSu->trinhDo->ten_trinh_do ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>