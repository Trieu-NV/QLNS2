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
                            <h4>Total Employees</h4>
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
                            <h4>Total Departments</h4>
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
                            <h4>Total Positions</h4>
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
                            <h4>Total Education Levels</h4>
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
                        <h4>Latest Employees</h4>
                        <div class="card-header-action">
                            <a href="#" class="btn btn-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Department</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestNhanSu as $nhanSu)
                                        <tr>
                                            <td>{{ $nhanSu->HoTen }}</td>
                                            <td>{{ $nhanSu->chucVu->TenChucVu ?? 'N/A' }}</td>
                                            <td>{{ $nhanSu->phongBan->TenPhongBan ?? 'N/A' }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="alert('Deleted')"><i class="fas fa-trash"></i></a>
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
                        <h4>Employee Statistics by Gender</h4>
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
                        <h4>Employee Statistics by Department</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="departmentChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Employee Statistics by Education Level</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="educationChart"></canvas>
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
                    labels: ['Male', 'Female', 'Other'],
                    datasets: [{
                        data: [{{ $genderStats['male'] ?? 0 }}, {{ $genderStats['female'] ?? 0 }}, {{ $genderStats['other'] ?? 0 }}],
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
                            text: 'Employee Statistics by Gender'
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
                        label: 'Number of Employees',
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
                            text: 'Employee Statistics by Department'
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
                            text: 'Employee Statistics by Education Level'
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection