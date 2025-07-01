<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HopDong;
use App\Models\NhanSu;

class HopDongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nhanSus = NhanSu::all();

        if ($nhanSus->isEmpty()) {
            $this->command->info('No NhanSu found. Please seed NhanSu table first.');
            return;
        }

        $baseSalary = 10000000;
        $baseStartDate = '2023-01-01';
        $baseSignDate = '2022-12-20';

        $i = 0;
        foreach ($nhanSus as $nhanSu) {
            // Tạo ngày bắt đầu và ngày ký khác nhau một chút cho từng nhân viên
            $ngayBatDau = date('Y-m-d', strtotime("$baseStartDate +$i days"));
            $ngayKy = date('Y-m-d', strtotime("$baseSignDate +$i days"));
            $ngayKetThuc = date('Y-m-d', strtotime("$ngayBatDau +1 year"));

            // Sinh mã hợp đồng tự động
            $latestHD = HopDong::orderBy('id', 'desc')->first();
            if ($latestHD) {
                $number = intval(substr($latestHD->id, 2)) + 1;
            } else {
                $number = 1;
            }
            $newId = 'HD' . str_pad($number, 5, '0', STR_PAD_LEFT);

            HopDong::create([
                'id' => $newId,
                'ma_nv' => $nhanSu->ma_nv,
                'loai_hop_dong' => 1, // Hợp đồng xác định thời hạn
                'luong' => $baseSalary,
                'ngay_bat_dau' => $ngayBatDau,
                'ngay_ket_thuc' => $ngayKetThuc,
                'ngay_ky' => $ngayKy,
                'so_lan_ky' => 1,
            ]);
            $i++;
        }
    }
}
