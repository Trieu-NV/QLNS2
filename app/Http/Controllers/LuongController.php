<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\NhanSu;
use App\Models\HopDong;
use App\Models\PhuCap;
use App\Models\ChamCong;
use Carbon\Carbon;

class LuongController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $congChuan = 22; // Standard working days in a month

        $employees = NhanSu::with(['phongBan', 'hopDong', 'phuCap'])
            ->where('trang_thai', true) // Filter for active employees
            ->get();

        $salaryData = [];
        foreach ($employees as $employee) {
            $basicSalary = $employee->hopDong->luong ?? 0;
            $totalAllowance = $employee->phuCap->sum('so_tien');

            // Calculate days off for the month/year
            $daysOff = ChamCong::where('ma_nv', $employee->ma_nv)
                ->whereYear('ngay', $year)
                ->whereMonth('ngay', $month)
                ->where('trang_thai', 'nghi') // Assuming 'nghi' means day off
                ->count();

            // Placeholder for bonus and penalty, as they are not in current models
            $bonus = 0; 
            $penalty = 0;

            $totalSalary = $basicSalary + $totalAllowance + $bonus - $penalty;
            if ($congChuan > 0) {
                $totalSalary -= ($basicSalary / $congChuan) * $daysOff;
            }

            $salaryData[] = [
                'ma_nv' => $employee->ma_nv,
                'ho_ten' => $employee->ho_ten,
                'phong_ban' => $employee->phongBan->ten_phong_ban ?? 'N/A',
                'luong_co_ban' => $basicSalary,
                'phu_cap' => $totalAllowance,
                'tien_thuong' => $bonus,
                'tien_phat' => $penalty,
                'so_ngay_nghi' => $daysOff,
                'tong_luong' => $totalSalary,
            ];
        }

        return view('luong', compact('salaryData', 'month', 'year'));
    }
}
