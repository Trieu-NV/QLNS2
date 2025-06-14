<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;
use GuzzleHttp\Psr7\Request;
use App\Http\Controllers\TaikhoanController ;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\PhongBanController;
use App\Http\Controllers\TrinhDoController;
use App\Http\Controllers\NhanSuController;
use App\Http\Controllers\PhuCapController;
use App\Http\Controllers\HopDongController;
use App\Http\Controllers\BaoHiemYteController;
use App\Http\Controllers\NhanVienPhuCapController;
use App\Http\Controllers\ChamCongController;
// Route::get('/', function () {
//     return Inertia::render('dashboard');
// })->name('home');

// ============LOGIN=========================
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('dashboard');
})->name('login.post');


Route::resource('cham-cong', ChamCongController::class);
// ===========================================
Route::get('/', function () {
    return view('home');
})->name('home');
// 

//===========NHAN SU=========================
Route::resource('nhan-su', NhanSuController::class);
Route::get('/api/nhan-su/search', [NhanSuController::class, 'search'])->name('nhan-su.search');
Route::get('nhan-su/export/excel', [NhanSuController::class, 'exportExcel'])->name('nhan-su.export.excel');
Route::get('nhan-su/export/pdf', [NhanSuController::class, 'exportPdf'])->name('nhan-su.export.pdf');


// ========================================
Route::get('/luong', function () {
     return view('luong');
})->name('luong');

// ==================DANH MUC==================
Route::resource('chuc-vu', ChucVuController::class);
Route::resource('phong-ban', PhongBanController::class);
Route::resource('trinh-do', TrinhDoController::class);
Route::resource('phu-cap', PhuCapController::class);
Route::get('phu-cap/{phu_cap}', [PhuCapController::class, 'show'])->name('phu-cap.show');
Route::resource('hop-dong', HopDongController::class);
Route::resource('bao-hiem-yte', BaoHiemYteController::class);
Route::resource('nhan-vien-phu-cap', NhanVienPhuCapController::class)->parameters([
    'nhan-vien-phu-cap' => 'ma_nv,id_phu_cap' // This is illustrative; actual parameter binding needs custom setup for composite keys in routes if not using a single primary key model.
]);
Route::get('nhan-vien-phu-cap/{ma_nv}/{id_phu_cap}/edit', [NhanVienPhuCapController::class, 'edit'])->name('nhan-vien-phu-cap.edit');
Route::put('nhan-vien-phu-cap/{ma_nv}/{id_phu_cap}', [NhanVienPhuCapController::class, 'update'])->name('nhan-vien-phu-cap.update');
Route::delete('nhan-vien-phu-cap/{ma_nv}/{id_phu_cap}', [NhanVienPhuCapController::class, 'destroy'])->name('nhan-vien-phu-cap.destroy');


// =========================================
// =================TAIKHOAN=========================
Route::resource('taikhoan', TaikhoanController::class);

// ===============USER=========================
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

// ============================================

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/settings.php'; // dùng để import các route phụ vào route chính
require __DIR__ . '/auth.php';
