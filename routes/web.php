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
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');

    // Home route (if authenticated)
    Route::get('/', function () {
        return view('home');
    })->name('home');

    // User profile routes
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.update-profile');
    Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.change-password');
    Route::put('/change-password', [UserController::class, 'changePassword'])->name('user.update-password');

    // User (Tài khoản) Routes
    Route::resource('users', UserController::class);

    // Cham Cong routes
    Route::resource('cham-cong', ChamCongController::class);

    // Nhan Su routes
    Route::resource('nhan-su', NhanSuController::class);
    Route::get('/api/nhan-su/search', [NhanSuController::class, 'search'])->name('nhan-su.search');
    Route::get('nhan-su/export/excel', [NhanSuController::class, 'exportExcel'])->name('nhan-su.export.excel');
    Route::get('nhan-su/export/pdf', [NhanSuController::class, 'exportPdf'])->name('nhan-su.export.pdf');

    // Luong route
    Route::get('/luong', function () {
         return view('luong');
    })->name('luong');

    // Danh Muc routes
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

    // Chuyen Can route
    Route::get('/chuyen-can', [ChuyenCanController::class, 'index'])->name('chuyen-can.index');

    // User specific routes (if different from 'users' resource)
    route::get('/user', function () {
        return view('user.index');
    })->name('user');
    Route::get('/user/edit', function () {
        return view('user.edit');
    })->name('user.edit');
    Route::post('/user/edit/{id}', function (Request $request, $id) {
        // Xử lý cập nhật thông tin người dùng ở đây
        return redirect()->route('user');
    })->name('user.edit.post');
});

require __DIR__ . '/settings.php'; // dùng để import các route phụ vào route chính
require __DIR__ . '/auth.php';
