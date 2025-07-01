<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class BaoHiemYteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nhanSus = \App\Models\NhanSu::all();

        if ($nhanSus->isEmpty()) {
            Log::info('No NhanSu found. Please seed NhanSu table first.');
            return;
        }

        $baseSoBaoHiem = 1000000000;
        $baseNgayCap = '2023-01-01';
        $noiCaps = ['TP.HCM', 'Hà Nội', 'Đà Nẵng', 'Cần Thơ', 'Hải Phòng'];
        $noiKhamBenhs = ['Bệnh viện A', 'Bệnh viện B', 'Bệnh viện C', 'Bệnh viện D', 'Bệnh viện E'];

        $i = 0;
        foreach ($nhanSus as $nhanSu) {
            $idbh = 'BH' . str_pad($i + 1, 5, '0', STR_PAD_LEFT);
            $so_bao_hiem = (string)($baseSoBaoHiem + $i);
            $ngay_cap = date('Y-m-d', strtotime("$baseNgayCap +$i months"));
            $noi_cap = $noiCaps[$i % count($noiCaps)];
            $noi_kham_benh = $noiKhamBenhs[$i % count($noiKhamBenhs)];

            \App\Models\BaoHiemYte::create([
                'idbh' => $idbh,
                'ma_nv' => $nhanSu->ma_nv,
                'so_bao_hiem' => $so_bao_hiem,
                'ngay_cap' => $ngay_cap,
                'noi_cap' => $noi_cap,
                'noi_kham_benh' => $noi_kham_benh,
            ]);
            $i++;
        }
    }
}
