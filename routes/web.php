<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;
use GuzzleHttp\Psr7\Request;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\PhongBanController;
use App\Http\Controllers\TrinhDoController;
use App\Http\Controllers\NhanSuController;
use App\Http\Controllers\PhuCapController;
use App\Http\Controllers\HopDongController;
use App\Http\Controllers\BaoHiemYteController;
use App\Http\Controllers\BaoHiemXaHoiController;
use App\Http\Controllers\ChamCongController;
use App\Http\Controllers\ChuyenCanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NhanVienPhuCapController;
use App\Http\Controllers\AuthController;

// Home route (if authenticated)
Route::get('/', [DashboardController::class, 'index'])->middleware(['check.username.cookie', 'check.permission:1'])->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.update');

// Temporary test route for logout
Route::get('/test-logout', [AuthController::class, 'testLogout'])->name('test.logout');
Route::get('/logout-alt', [AuthController::class, 'logoutAlternative'])->name('logout.alt');
Route::get('/logout-final', [AuthController::class, 'logoutFinal'])->name('logout.final');
Route::get('/test-logout-page', function() {
    return view('auth.test-logout');
})->name('test.logout.page');

// Password change routes (for authenticated users)
Route::middleware(['check.username.cookie'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/edit', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.update');
});

   

// Routes cho Admin (loaitk = 0) - Quản lý tài khoản user
Route::middleware(['check.username.cookie', 'check.permission:0'])->group(function () {
    Route::resource('users', UserController::class);
});

// Routes cho HR (loaitk = 1) - Quản lý nhân sự, hợp đồng, lương, v.v.
Route::middleware(['check.username.cookie', 'check.permission:1'])->group(function () {
    
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
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
    Route::resource('bao-hiem-xa-hoi', BaoHiemXaHoiController::class);
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
