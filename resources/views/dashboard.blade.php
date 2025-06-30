@extends('layouts.app')

@section('title', 'Dashboard')

@section('page_title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tổng nhân sự</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalNhanSu }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tổng phòng ban</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalPhongBan }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tổng chức vụ</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalChucVu }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tổng trình độ</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalTrinhDo }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Nhân sự mới nhất</h4>
                        <div class="card-header-action">
                            <a href="#" class="btn btn-primary">Xem tất cả</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Họ tên</th>
                                        <th>Chức vụ</th>
                                        <th>Phòng ban</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestNhanSu as $nhanSu)
                                        <tr>
                                            <td>{{ $nhanSu->ho_ten }}</td>
                                            <td>{{ $nhanSu->chucVu->ten_chuc_vu ?? 'N/A' }}</td>
                                            <td>{{ $nhanSu->phongBan->ten_phong_ban ?? 'N/A' }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Sửa"><i class="fas fa-pencil-alt"></i></a>
                                                <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Xóa" data-confirm="Bạn có chắc chắn?|Hành động này không thể hoàn tác. Bạn muốn tiếp tục?" data-confirm-yes="alert('Đã xóa')"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thống kê nhân sự theo giới tính</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thống kê nhân sự theo phòng ban</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="departmentChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thống kê nhân sự theo trình độ</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="educationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thống kê nhân sự theo độ tuổi</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="ageChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lương trung bình theo phòng ban</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="salaryDeptChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tóm tắt lương toàn công ty</h4>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Lương trung bình: <b>{{ number_format($avgSalary, 0, ',', '.') }}</b></li>
                            <li>Lương cao nhất: <b>{{ number_format($maxSalary, 0, ',', '.') }}</b></li>
                            <li>Lương thấp nhất: <b>{{ number_format($minSalary, 0, ',', '.') }}</b></li>
                            <li>Tổng quỹ lương: <b>{{ number_format($totalSalary, 0, ',', '.') }}</b></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tổng lương chi trả cho nhân viên trong 6 tháng gần nhất</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="salary6MonthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Gender Chart
            var genderCtx = document.getElementById('genderChart').getContext('2d');
            var genderChart = new Chart(genderCtx, {
                type: 'pie',
                data: {
                    labels: ['Nam', 'Nữ', 'Khác'],
                    datasets: [{
                        data: [{{ $genderStats['Nam'] ?? 0 }}, {{ $genderStats['Nữ'] ?? 0 }}, {{ $genderStats['Khác'] ?? 0 }}],
                        backgroundColor: ['#6777ef', '#fc544b', '#ffa426'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                            text: 'Thống kê nhân sự theo giới tính'
                        }
                    }
                }
            });

            // Department Chart
            var departmentCtx = document.getElementById('departmentChart').getContext('2d');
            var departmentChart = new Chart(departmentCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($departmentStats)) !!},
                    datasets: [{
                        label: 'Số lượng nhân sự',
                        data: {!! json_encode(array_values($departmentStats)) !!},
                        backgroundColor: '#6777ef',
                        borderColor: '#6777ef',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: false,
                            text: 'Thống kê nhân sự theo phòng ban'
                        }
                    }
                }
            });

            // Education Chart
            var educationCtx = document.getElementById('educationChart').getContext('2d');
            var educationChart = new Chart(educationCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($educationStats)) !!},
                    datasets: [{
                        data: {!! json_encode(array_values($educationStats)) !!},
                        backgroundColor: ['#6777ef', '#fc544b', '#ffa426', '#191d21', '#63ed7a'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                            text: 'Thống kê nhân sự theo trình độ'
                        }
                    }
                }
            });

            // Age Chart
            var ageCtx = document.getElementById('ageChart').getContext('2d');
            var ageChart = new Chart(ageCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($ageStats)) !!},
                    datasets: [{
                        label: 'Số lượng nhân sự',
                        data: {!! json_encode(array_values($ageStats)) !!},
                        backgroundColor: '#36a2eb',
                        borderColor: '#36a2eb',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: { display: false, text: 'Thống kê nhân sự theo độ tuổi' }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Salary by Department Chart
            var salaryDeptCtx = document.getElementById('salaryDeptChart').getContext('2d');
            var salaryDeptChart = new Chart(salaryDeptCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($avgSalaryByDept)) !!},
                    datasets: [{
                        label: 'Lương trung bình',
                        data: {!! json_encode(array_values($avgSalaryByDept)) !!},
                        backgroundColor: '#ffa426',
                        borderColor: '#ffa426',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: { display: false, text: 'Lương trung bình theo phòng ban' }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Salary 6 Month Chart
            var salary6MonthCtx = document.getElementById('salary6MonthChart').getContext('2d');
            var salary6MonthChart = new Chart(salary6MonthCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_keys($salaryByMonth)) !!},
                    datasets: [{
                        label: 'Tổng lương chi trả',
                        data: {!! json_encode(array_values($salaryByMonth)) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: '#36a2eb',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: true },
                        title: { display: false, text: 'Tổng lương chi trả cho nhân viên trong 6 tháng gần nhất' }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            });
        </script>
    @endpush
@endsection