@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #f0f2f5; /* Màu nền tổng thể nhẹ nhàng */
        }

        .main-content {
            padding-top: 20px;
        }

        .breadcrumb {
            font-size: 0.9rem;
        }
        .breadcrumb-item a {
            text-decoration: none;
            color: #0d6efd;
        }
        .breadcrumb-item.active {
            color: #6c757d;
        }

        .profile-sidebar {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.075);
            border-right: 1px solid #e0e0e0;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: block;
            object-fit: cover;
            border: 3px solid #0d6efd; /* Viền avatar */
        }

        .profile-sidebar .username {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .profile-sidebar .user-role {
            font-size: 0.95rem;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .profile-info-list {
            list-style: none;
            padding: 0;
            font-size: 0.9rem;
        }

        .profile-info-list li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            color: #555;
        }
        .profile-info-list li:last-child {
            border-bottom: none;
        }
        .profile-info-list li .info-label {
            color: #333;
        }
        .profile-info-list li .info-value {
            font-weight: 500;
            color: #0d6efd; /* Màu giá trị nổi bật */
        }
         .profile-info-list li .info-value.status-active {
            color: #198754; /* Màu xanh cho trạng thái hoạt động */
        }

        .form-section {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.075);
        }
        .form-section h5 {
            font-weight: 600;
            margin-bottom: 25px;
            color: #333;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
        }
        .form-control:disabled, .form-control[readonly] {
            background-color: #e9ecef; /* Màu nền cho input bị disable/readonly */
            opacity: 1;
        }
        .required-field::after {
            content: " *";
            color: red;
        }
    </style>

    <div class="container main-content">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="profile-sidebar text-center">
                    <img src="/storage/avatar.png" alt="Avatar" class="profile-avatar">
                    <h4 class="username">Nguyễn Văn Triệu</h4>
                    <p class="user-role">Admin</p>
                    <hr>
                    <ul class="profile-info-list text-start">
                       
                        <li>
                            <span class="info-label">Ngày tạo:</span>
                            <span class="info-value">01/05/2025</span>
                        </li>
                        <li>
                            <span class="info-label">Ngày sửa:</span>
                            <span class="info-value">01/05/2025</span>
                        </li>s
                        <!-- <li>
                            <span class="info-label">Trạng thái:</span>
                            <span class="info-value status-active">Đang hoạt động</span>
                        </li> -->
                    </ul>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="form-section">
                    <h5>Thay đổi thông tin</h5>
                    <form>
                        <div class="mb-3">
                            <label for="chonAnh" class="form-label">Chọn ảnh:</label>
                            <input class="form-control" type="file" id="chonAnh">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ho" class="form-label required-field">Họ</label>
                                <input type="text" class="form-control" id="ho" value="Nguyễn" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ten" class="form-label required-field">Tên</label>
                                <input type="text" class="form-control" id="ten" value="Văn Triệu" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" value="trieug88@gmail.com" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="soDienThoai" class="form-label">Số điện thoại:</label>
                            <input type="tel" class="form-control" id="soDienThoai" value="0328137723">
                        </div>

                       

                       

                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Lưu lại</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

  
@endsection