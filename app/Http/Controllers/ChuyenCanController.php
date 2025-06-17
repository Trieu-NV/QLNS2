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
        $selectedMonth = $request->input('month', Carbon::now()->month);
        $selectedYear = $request->input('year', Carbon::now()->year);

        $chuyenCanData = [];
        $nhanSuList = NhanSu::where('trang_thai', 1)->with('phongBan')->get(); // Only active employees

        // Define holidays (example, should be configurable or fetched from a source)
        $holidays = [
            // Format: 'Y-m-d'
            // Example: $selectedYear . '-01-01', // New Year
            // $selectedYear . '-04-30', // Liberation Day
            // $selectedYear . '-05-01', // International Workers' Day
            // $selectedYear . '-09-02', // National Day
        ];

        foreach ($nhanSuList as $nhanSu) {
            $firstDayOfMonth = Carbon::create($selectedYear, $selectedMonth, 1);
            $daysInMonth = $firstDayOfMonth->daysInMonth;
            $soNgayCongChuan = 0; // Bắt đầu từ 0

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate = Carbon::create($selectedYear, $selectedMonth, $day);
                // Check if it's a Sunday (dayOfWeek == 0) or a holiday
                if ($currentDate->dayOfWeek != Carbon::SUNDAY && !in_array($currentDate->toDateString(), $holidays)) {
                    $soNgayCongChuan++;
                }
            }

            $attendances = ChamCong::where('ma_nv', $nhanSu->ma_nv)
                                ->whereYear('ngay', $selectedYear)
                                ->whereMonth('ngay', $selectedMonth)
                                ->get();

            $soNgayDiLam = (int)$attendances->where('trang_thai', 'Đi Làm')->count();
            $soNgayNghi = (int)$attendances->where('trang_thai', 'Nghỉ')->count();
            $soNgayPhep = (int)$attendances->where('trang_thai', 'Phép')->count();

            $tienThuong = 0;
            
            // Điều kiện tính tiền thưởng mềm hơn
            if ($soNgayNghi == 0 && $soNgayPhep <= 2 && ($soNgayDiLam + $soNgayPhep) >= ($soNgayCongChuan - 1)) {
                $tienThuong = 500000;
            }

            // Tính tiền phạt
            $tienPhat = $soNgayNghi * 50000;

            // Store or update ChuyenCan record
            $chuyenCanEntry = \App\Models\ChuyenCan::firstOrNew(
                ['ma_nv' => $nhanSu->ma_nv, 'thang_nam' => $firstDayOfMonth->format('Y-m-01')],


            );

            $chuyenCanEntry->so_cong_chuan = $soNgayCongChuan;
            $chuyenCanEntry->so_ngay_di_lam = $soNgayDiLam;
            $chuyenCanEntry->so_ngay_nghi = $soNgayNghi;
            $chuyenCanEntry->so_ngay_phep = $soNgayPhep;
            $chuyenCanEntry->tien_thuong = $tienThuong;
            $chuyenCanEntry->tien_phat = $tienPhat;
            $chuyenCanEntry->save();

            $chuyenCanData[] = [
                'ma_nv' => $nhanSu->ma_nv,
                'ho_ten' => $nhanSu->ho_ten,
                'ten_phong_ban' => $nhanSu->phongBan ? $nhanSu->phongBan->ten_phong_ban : 'N/A',
                'thang_nam' => $firstDayOfMonth->format('m/Y'),
                'so_cong_chuan' => $soNgayCongChuan,
                'so_ngay_di_lam' => $soNgayDiLam,
                'so_ngay_nghi' => $soNgayNghi,
                'so_ngay_phep' => $soNgayPhep,
                'tien_thuong' => $tienThuong,
                'tien_phat' => $tienPhat,
            ];
        }

        return view('chuyen-can.index', compact('chuyenCanData', 'selectedMonth', 'selectedYear'));
    }
}