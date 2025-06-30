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

        // Thống kê độ tuổi
        $ageStats = [
            'Dưới 25' => 0,
            '25-34' => 0,
            '35-44' => 0,
            '45-54' => 0,
            '55+' => 0,
        ];
        $now = now();
        foreach (NhanSu::all() as $ns) {
            if (!$ns->ngay_sinh) continue;
            $age = $now->diffInYears($ns->ngay_sinh);
            if ($age < 25) $ageStats['Dưới 25']++;
            elseif ($age < 35) $ageStats['25-34']++;
            elseif ($age < 45) $ageStats['35-44']++;
            elseif ($age < 55) $ageStats['45-54']++;
            else $ageStats['55+']++;
        }

        // Lương trung bình theo phòng ban
        $departments = PhongBan::with(['nhanSu.hopDongGanNhat'])->get();
        $avgSalaryByDept = [];
        foreach ($departments as $pb) {
            $total = 0; $count = 0;
            foreach ($pb->nhanSu as $ns) {
                $salary = $ns->hopDongGanNhat->luong ?? 0;
                if ($salary > 0) {
                    $total += $salary;
                    $count++;
                }
            }
            $avgSalaryByDept[$pb->ten_phong_ban] = $count ? round($total/$count,0) : 0;
        }

        // Lương trung bình toàn công ty, lương cao nhất/thấp nhất, tổng quỹ lương tháng
        $allSalaries = [];
        foreach (NhanSu::with('hopDongGanNhat')->get() as $ns) {
            $salary = $ns->hopDongGanNhat->luong ?? 0;
            if ($salary > 0) $allSalaries[] = $salary;
        }
        $avgSalary = count($allSalaries) ? round(array_sum($allSalaries)/count($allSalaries),0) : 0;
        $maxSalary = count($allSalaries) ? max($allSalaries) : 0;
        $minSalary = count($allSalaries) ? min($allSalaries) : 0;
        $totalSalary = array_sum($allSalaries);

        // Tổng lương chi trả 6 tháng gần nhất
        $salaryByMonth = [];
        $now = now();
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $label = $month->format('m/Y');
            $total = 0;
            foreach (NhanSu::with('hopDongGanNhat')->get() as $ns) {
                $salary = $ns->hopDongGanNhat->luong ?? 0;
                if ($salary > 0) $total += $salary;
            }
            $salaryByMonth[$label] = $total;
        }

        return view('dashboard', compact(
            'totalNhanSu', 'totalPhongBan', 'totalChucVu', 'totalTrinhDo', 'latestNhanSu',
            'genderStats', 'departmentStats', 'educationStats',
            'ageStats', 'avgSalaryByDept', 'avgSalary', 'maxSalary', 'minSalary', 'totalSalary',
            'salaryByMonth'
        ));
    }
}
