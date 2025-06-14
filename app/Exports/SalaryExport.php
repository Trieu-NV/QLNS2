<?php

namespace App\Exports;

use App\Models\NhanSu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\HopDong;
use App\Models\PhuCap;
use App\Models\ChamCong;
use Carbon\Carbon;

class SalaryExport implements FromCollection, WithHeadings
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $month = $this->month;
        $year = $this->year;
        $congChuan = 22; // Standard working days in a month

        $employees = NhanSu::with(['phongBan', 'hopDong', 'phuCap'])
            ->where('trang_thai', true)
            ->get();

        $salaryData = [];
        foreach ($employees as $employee) {
            $basicSalary = $employee->hopDong->luong ?? 0;
            $totalAllowance = $employee->phuCap->sum('so-tien');

            $daysOff = ChamCong::where('ma_nv', $employee->ma_nv)
                ->whereYear('ngay', $year)
                ->whereMonth('ngay', $month)
                ->where('trang_thai', 'nghi')
                ->count();

            $bonus = 0;
            $penalty = 0;

            $totalSalary = $basicSalary + $totalAllowance + $bonus - $penalty;
            if ($congChuan > 0) {
                $totalSalary -= ($basicSalary / $congChuan) * $daysOff;
            }

            $salaryData[] = [
                $employee->ma_nv,
                $employee->ho_ten,
                $employee->phongBan->ten_phong_ban ?? 'N/A',
                $basicSalary,
                $totalAllowance,
                $bonus,
                $penalty,
                $daysOff,
                $totalSalary,
            ];
        }

        return collect($salaryData);
    }

    public function headings(): array
    {
        return [
            'Mã NV',
            'Họ Tên',
            'Phòng Ban',
            'Lương Cơ Bản',
            'Phụ Cấp',
            'Tiền Thưởng',
            'Tiền Phạt',
            'Số Ngày Nghỉ',
            'Tổng Lương',
        ];
    }
}
