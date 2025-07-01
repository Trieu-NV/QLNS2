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
use App\Models\PhongBan;

class LuongController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $congChuan = 22; // Standard working days in a month

        $phongBanId = $request->input('phong_ban');
        $sortBy = $request->input('sort_by', 'tong_luong');
        $sortOrder = $request->input('sort_order', 'desc');

        $employeesQuery = NhanSu::with(['phongBan', 'hopDongGanNhat', 'phuCap'])
            ->where('trang_thai', true);
        if ($phongBanId) {
            $employeesQuery->where('id_phong_ban', $phongBanId);
        }
        $employees = $employeesQuery->get();

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

            // Tính tổng tiền bảo hiểm nhân viên đóng
            $insurance = $basicSalary * (0.08 + 0.015 + 0.01); // 8% BHXH + 1.5% BHYT + 1% BHTN

            $totalSalary = $basicSalary + $totalAllowance + $bonus - $penalty;
            if ($congChuan > 0) {
                $totalSalary -= ($basicSalary / $congChuan) * $daysOff;
            }
            $totalSalary -= $insurance;

            $salaryData[] = [
                'ma_nv' => $employee->ma_nv,
                'ho_ten' => $employee->ho_ten,
                'phong_ban' => $employee->phongBan->ten_phong_ban ?? 'N/A',
                'luong_co_ban' => $basicSalary,
                'phu_cap' => $totalAllowance,
                'tien_thuong' => $bonus,
                'tien_phat' => $penalty,
                'so_ngay_nghi' => $daysOff,
                'bao_hiem_nv' => $insurance,
                'tong_luong' => $totalSalary,
            ];
        }
        // Sắp xếp salaryData
        usort($salaryData, function($a, $b) use ($sortBy, $sortOrder) {
            if ($sortOrder === 'asc') {
                return $a[$sortBy] <=> $b[$sortBy];
            } else {
                return $b[$sortBy] <=> $a[$sortBy];
            }
        });

        $phongBans = PhongBan::all();
        return view('luong', compact('salaryData', 'month', 'year', 'phongBans', 'phongBanId', 'sortBy', 'sortOrder'));
    }

    public function export(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        return Excel::download(new SalaryExport($month, $year), 'bang_luong_' . $month . '_' . $year . '.xlsx');
    }
}
