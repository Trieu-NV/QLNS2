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
        $check =DB::select('select * from users where username = ?',[$username]);
        $hashedPassword = $check[0]->password;
        $response = response(redirect('/login'));
        // Set the cookie
        if(count($check) > 0 && Hash::check($password, $hashedPassword)){
            $loaitk = $check[0]->loaitk;
            if($loaitk == 0){
                //TODO: sua lai ve giao dien ql tài khoản
                $response = response(redirect('/luong'));
            }
            if($loaitk == 1){
                $response = response(redirect('/dashboard'));
            }
            if($loaitk == 2){
                $response = response(redirect('/cham-cong'));
            }
        }
        $response->cookie('username', $username, 60); // Cookie expires in 60 minutes
        return $response;
    })->withoutMiddleware('check.username.cookie')->name('login.post');
  


        Route::resource('cham-cong', ChamCongController::class);
        Route::get('/chuyen-can', [ChuyenCanController::class, 'index'])->name('chuyen-can.index');
        Route::resource('nhan-su', NhanSuController::class);
        Route::get('/api/nhan-su/search', [NhanSuController::class, 'search'])->name('nhan-su.search');
        Route::get('nhan-su/export/excel', [NhanSuController::class, 'exportExcel'])->name('nhan-su.export.excel');
        Route::get('nhan-su/export/pdf', [NhanSuController::class, 'exportPdf'])->name('nhan-su.export.pdf');

        Route::get('/luong', [App\Http\Controllers\LuongController::class, 'index'])->name('luong');

        Route::get('/luong/report', [App\Http\Controllers\LuongController::class, 'index'])->name('luong.report');

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



require __DIR__ . '/settings.php'; // dùng để import các route phụ vào route chính
require __DIR__ . '/auth.php';
