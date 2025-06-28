<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\NhanSu;
use App\Models\HopDong;
use App\Models\PhuCap;
use App\Models\ChamCong;
use App\Models\ChuyenCan;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalaryExport;

class LuongController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $congChuan = 22; // Standard working days in a month

        $employees = NhanSu::with(['phongBan', 'hopDongGanNhat', 'phuCap'])
            ->where('trang_thai', true) // Filter for active employees
            ->get();

        $salaryData = [];
        foreach ($employees as $employee) {
            // Lấy lương cơ bản từ hợp đồng gần nhất (có so_lan_ky cao nhất)
            $basicSalary = $employee->hopDongGanNhat->luong ?? 0;
            $totalAllowance = $employee->phuCap->sum('so-tien');

            // Lấy dữ liệu chuyên cần
            $chuyenCan = ChuyenCan::where('ma_nv', $employee->ma_nv)
                ->whereYear('thang_nam', $year)
                ->whereMonth('thang_nam', $month)
                ->first();

            // Tính số ngày nghỉ từ bảng chấm công
            $daysOff = ChamCong::where('ma_nv', $employee->ma_nv)
                ->whereYear('ngay', $year)
                ->whereMonth('ngay', $month)
                ->where('trang_thai', 'Nghỉ')
                ->count();

            // Lấy tiền thưởng và tiền phạt từ bảng chuyên cần
            $bonus = $chuyenCan ? $chuyenCan->tien_thuong : 0;
            $penalty = $chuyenCan ? $chuyenCan->tien_phat : 0;

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

    public function export(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        return Excel::download(new SalaryExport($month, $year), 'bang_luong_' . $month . '_' . $year . '.xlsx');
    }
}
