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

        $contracts = [
            [
                'ma_nv' => $nhanSus->random()->ma_nv,
                'loai_hop_dong' => 1, // Fixed-term
                'luong' => 10000000,
                'ngay_bat_dau' => '2023-01-01',
                'ngay_ket_thuc' => '2024-01-01',
                'ngay_ky' => '2022-12-20',
                'so_lan_ky' => 1,
            ],
            [
                'ma_nv' => $nhanSus->random()->ma_nv,
                'loai_hop_dong' => 2, // Indefinite-term
                'luong' => 15000000,
                'ngay_bat_dau' => '2022-05-10',
                'ngay_ket_thuc' => null,
                'ngay_ky' => '2022-05-01',
                'so_lan_ky' => 1,
            ],
            [
                'ma_nv' => $nhanSus->random()->ma_nv,
                'loai_hop_dong' => 1, // Fixed-term, renewable once
                'luong' => 12000000,
                'ngay_bat_dau' => '2024-03-15',
                'ngay_ket_thuc' => '2025-03-15',
                'ngay_ky' => '2024-03-01',
                'so_lan_ky' => 2,
            ],
        ];

        foreach ($contracts as $contractData) {
            // Generate custom ID for HopDong
            $latestHD = HopDong::orderBy('id', 'desc')->first();
            if ($latestHD) {
                $number = intval(substr($latestHD->id, 2)) + 1;
            } else {
                $number = 1;
            }
            $newId = 'HD' . str_pad($number, 5, '0', STR_PAD_LEFT);

            HopDong::create(array_merge($contractData, ['id' => $newId]));
        }
    }
}
