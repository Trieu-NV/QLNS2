<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NhanSu;
use App\Models\PhongBan;
use App\Models\ChucVu;
use App\Models\TrinhDo;

class DashboardController extends Controller
{
    public function index()
    {
        $totalNhanSu = NhanSu::count();
        $totalPhongBan = PhongBan::count();
        $totalChucVu = ChucVu::count();
        $totalTrinhDo = TrinhDo::count();

        $latestNhanSu = NhanSu::with(['chucVu', 'phongBan'])->latest()->take(5)->get();

        $genderStats = NhanSu::selectRaw('gioi_tinh, count(*) as count')
            ->groupBy('gioi_tinh')
            ->pluck('count', 'gioi_tinh')
            ->toArray();

        $departmentStats = NhanSu::join('phong_ban', 'nhan_su.id_phong_ban', '=', 'phong_ban.id')
            ->selectRaw('phong_ban.ten_phong_ban, count(*) as count')
            ->groupBy('phong_ban.ten_phong_ban')
            ->pluck('count', 'phong_ban.ten_phong_ban')
            ->toArray();

        $educationStats = NhanSu::join('trinh_do', 'nhan_su.id_trinh_do', '=', 'trinh_do.id')
            ->selectRaw('trinh_do.ten_trinh_do, count(*) as count')
            ->groupBy('trinh_do.ten_trinh_do')
            ->pluck('count', 'trinh_do.ten_trinh_do')
            ->toArray();

        return view('dashboard', compact('totalNhanSu', 'totalPhongBan', 'totalChucVu', 'totalTrinhDo', 'latestNhanSu', 'genderStats', 'departmentStats', 'educationStats'));
    }
}
