<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;
use GuzzleHttp\Psr7\Request;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\PhongBanController;
use App\Http\Controllers\TrinhDoController;
use App\Http\Controllers\NhanSuController;
use App\Http\Controllers\PhuCapController;
use App\Http\Controllers\HopDongController;
use App\Http\Controllers\BaoHiemYteController;
use App\Http\Controllers\NhanVienPhuCapController;
use App\Http\Controllers\ChamCongController;
use App\Http\Controllers\ChuyenCanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

    // Dashboard route
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');

    // Home route (if authenticated)
    Route::get('/', function () {
        return view('home');
    })->middleware('check.username.cookie')->name('home');

    Route::get('/login', function () {
        return view('login');
    })->withoutMiddleware('check.username.cookie')->name('login');//không chạy trên route này

    Route::post('/login', function (Illuminate\Http\Request $request) {
        //lấy dât từ request
        $username = $request->input('username'); // Get username from request or use a default
        $password = $request->input('password');
        
        // Kiểm tra username và password có được nhập không
        if (empty($username) || empty($password)) {
            return redirect('/login')->with('error', 'Vui lòng nhập đầy đủ username và password.');
        }
        
        $check = DB::select('select * from users where username = ?', [$username]);
        
        // Kiểm tra user có tồn tại không
        if (count($check) == 0) {
            return redirect('/login')->with('error', 'Username không tồn tại.');
        }
        
        $hashedPassword = $check[0]->password;
        
        // Kiểm tra password có đúng không
        if (!Hash::check($password, $hashedPassword)) {
            return redirect('/login')->with('error', 'Password không đúng.');
        }
        
        // Đăng nhập thành công
        $loaitk = $check[0]->loaitk;
        $response = null;
        
        if ($loaitk == 0) {
            // Admin - chuyển đến quản lý tài khoản
            $response = redirect('/users');
        } elseif ($loaitk == 1) {
            // HR - chuyển đến dashboard
            $response = redirect('/dashboard');
        } elseif ($loaitk == 2) {
            // Tổ trưởng - chuyển đến chấm công
            $response = redirect('/cham-cong');
        } else {
            // Loại tài khoản không xác định
            $response = redirect('/dashboard');
        }
        
        // Set cookie và thông báo thành công
        $response->cookie('username', $username, 60); // Cookie expires in 60 minutes
        return $response->with('success', 'Đăng nhập thành công!');
        
    })->withoutMiddleware('check.username.cookie')->name('login.post');
  
    // Routes cho tất cả loại tài khoản
    Route::middleware(['check.username.cookie'])->group(function () {
        // Dashboard cho tất cả
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    });

    // Routes cho Admin (loaitk = 0) - Quản lý tài khoản user
    Route::middleware(['check.username.cookie', 'check.permission:0'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Routes cho HR (loaitk = 1) - Quản lý nhân sự, hợp đồng, lương, v.v.
    Route::middleware(['check.username.cookie', 'check.permission:1'])->group(function () {
        Route::resource('nhan-su', NhanSuController::class);
        Route::get('/api/nhan-su/search', [NhanSuController::class, 'search'])->name('nhan-su.search');
        Route::get('nhan-su/export/excel', [NhanSuController::class, 'exportExcel'])->name('nhan-su.export.excel');
        Route::get('nhan-su/export/pdf', [NhanSuController::class, 'exportPdf'])->name('nhan-su.export.pdf');
        Route::get('/luong', [App\Http\Controllers\LuongController::class, 'index'])->name('luong');
        Route::get('/luong/report', [App\Http\Controllers\LuongController::class, 'index'])->name('luong.report');
        Route::get('/luong/export', [App\Http\Controllers\LuongController::class, 'export'])->name('luong.export');
        Route::resource('chuc-vu', ChucVuController::class);
        Route::resource('phong-ban', PhongBanController::class);
        Route::resource('trinh-do', TrinhDoController::class);
        Route::resource('phu-cap', PhuCapController::class);
        Route::get('phu-cap/{phu_cap}', [PhuCapController::class, 'show'])->name('phu-cap.show');
        Route::resource('hop-dong', HopDongController::class);
        Route::resource('bao-hiem-yte', BaoHiemYteController::class);
        Route::resource('nhan-vien-phu-cap', NhanVienPhuCapController::class)->parameters([
            'nhan-vien-phu-cap' => 'ma_nv,id_phu_cap'
        ]);
        Route::get('nhan-vien-phu-cap/{ma_nv}/{id_phu_cap}/edit', [NhanVienPhuCapController::class, 'edit'])->name('nhan-vien-phu-cap.edit');
        Route::put('nhan-vien-phu-cap/{ma_nv}/{id_phu_cap}', [NhanVienPhuCapController::class, 'update'])->name('nhan-vien-phu-cap.update');
        Route::delete('nhan-vien-phu-cap/{ma_nv}/{id_phu_cap}', [NhanVienPhuCapController::class, 'destroy'])->name('nhan-vien-phu-cap.destroy');
    });

    // Routes cho Tổ trưởng (loaitk = 2) - Quản lý chấm công và chuyên cần
    Route::middleware(['check.username.cookie', 'check.permission:2'])->group(function () {
        Route::resource('cham-cong', ChamCongController::class);
        Route::get('/chuyen-can', [ChuyenCanController::class, 'index'])->name('chuyen-can.index');
    });

require __DIR__ . '/settings.php'; // dùng để import các route phụ vào route chính
require __DIR__ . '/auth.php';
