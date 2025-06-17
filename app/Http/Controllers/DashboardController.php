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

        $genderStats = NhanSu::selectRaw('GioiTinh, count(*) as count')
            ->groupBy('GioiTinh')
            ->pluck('count', 'GioiTinh')
            ->toArray();

        $departmentStats = NhanSu::join('phong_bans', 'nhan_sus.MaPhongBan', '=', 'phong_bans.MaPhongBan')
            ->selectRaw('phong_bans.TenPhongBan, count(*) as count')
            ->groupBy('phong_bans.TenPhongBan')
            ->pluck('count', 'phong_bans.TenPhongBan')
            ->toArray();

        $educationStats = NhanSu::join('trinh_dos', 'nhan_sus.MaTrinhDo', '=', 'trinh_dos.MaTrinhDo')
            ->selectRaw('trinh_dos.TenTrinhDo, count(*) as count')
            ->groupBy('trinh_dos.TenTrinhDo')
            ->pluck('count', 'trinh_dos.TenTrinhDo')
            ->toArray();

        return view('dashboard', compact('totalNhanSu', 'totalPhongBan', 'totalChucVu', 'totalTrinhDo', 'latestNhanSu', 'genderStats', 'departmentStats', 'educationStats'));
    }
}
