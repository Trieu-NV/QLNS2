<?php

namespace App\Http\Controllers;

use App\Models\ChamCong;
use App\Models\NhanSu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChuyenCanController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = $request->input('month', Carbon::now()->month);
        $currentYear = $request->input('year', Carbon::now()->year);

        // Logic to fetch and process data will be added here
        $chuyenCanData = []; // Placeholder for data

        // Example: Fetch all NhanSu for now, will refine later
        $nhanSuList = NhanSu::with('phongBan')->get();

        foreach ($nhanSuList as $nhanSu) {
            // Calculate SoCong, TienThuong, TienPhat for each nhanSu
            // This is a simplified version, actual calculation will be more complex
            $soCong = 0; // Placeholder
            $tienThuong = 0; // Placeholder
            $tienPhat = 0; // Placeholder

            // Example: Get attendance for the current month and year for this employee
            $attendances = ChamCong::where('ma_nv', $nhanSu->ma_nv)
                                ->whereYear('ngay', $currentYear)
                                ->whereMonth('ngay', $currentMonth)
                                ->get();

            $soNgayDiLam = $attendances->whereIn('trang_thai', ['Đi làm', 'Phép'])->count();
            // Assuming 'Phép' also counts as a working day for bonus/penalty calculation

            $soCong = $soNgayDiLam;

            if ($soCong > 22) {
                $tienThuong = 500000;
            }

            // Example penalty: if working days < 15, penalty of 200,000 VND
            // This threshold can be adjusted
            if ($soCong < 15 && $soCong > 0) { // Avoid penalty if 0 days (e.g. new employee mid-month)
                $tienPhat = 200000;
            }


            $chuyenCanData[] = [
                'ma_nv' => $nhanSu->ma_nv,
                'ho_ten' => $nhanSu->ho_ten,
                'ten_phong_ban' => $nhanSu->phongBan ? $nhanSu->phongBan->ten_phong_ban : 'N/A',
                'thang' => $currentMonth,
                'nam' => $currentYear,
                'so_cong' => $soCong,
                'tien_thuong' => $tienThuong,
                'tien_phat' => $tienPhat,
            ];
        }

        return view('chuyen-can.index', compact('chuyenCanData', 'currentMonth', 'currentYear'));
    }
}