<?php

namespace App\Http\Controllers;

use App\Models\BaoHiemXaHoi;
use App\Models\NhanSu;
use App\Models\HopDong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BaoHiemXaHoiController extends Controller
{
   

    public function index(Request $request)
    {
        $thang_nam = $request->input('thang_nam', now()->format('Y-m'));
        $nhanSus = NhanSu::with(['hopDong' => function($q) {
            $q->latest('id');
        }])->get();

        $dsBaoHiem = [];
        foreach ($nhanSus as $nhanSu) {
            $hopDong = $nhanSu->hopDong()->latest('id')->first();
            if (!$hopDong) continue;
            $luong = $hopDong->luong;
            $dsBaoHiem[] = [
                'nhan_su' => $nhanSu,
                'luong' => $luong,
                // Người lao động
                'bhxh_nv' => $luong * 0.08,
                'bhyt_nv' => $luong * 0.015,
                'bhtn_nv' => $luong * 0.01,
                'tong_nv' => $luong * 0.105,
                // Doanh nghiệp
                'bhxh_dn' => $luong * 0.175,
                'bhyt_dn' => $luong * 0.03,
                'bhtn_dn' => $luong * 0.01,
                'kinh_phi_cong_doan' => $luong * 0.02,
                'tong_dn' => $luong * 0.215,
            ];
        }
        return view('bao-hiem-xa-hoi.index', compact('dsBaoHiem', 'thang_nam'));
    }
} 