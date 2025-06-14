<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BaoHiemYteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\BaoHiemYte::create([
            'idbh' => 'BH00001',
            'ma_nv' => 'NV0001',
            'so_bao_hiem' => '1234567890',
            'ngay_cap' => '2023-01-01',
            'noi_cap' => 'TP.HCM',
            'noi_kham_benh' => 'Bệnh viện A',
        ]);

        \App\Models\BaoHiemYte::create([
            'idbh' => 'BH00002',
            'ma_nv' => 'NV0002',
            'so_bao_hiem' => '0987654321',
            'ngay_cap' => '2023-02-01',
            'noi_cap' => 'Hà Nội',
            'noi_kham_benh' => 'Bệnh viện B',
        ]);

        \App\Models\BaoHiemYte::create([
            'idbh' => 'BH00003',
            'ma_nv' => 'NV0003',
            'so_bao_hiem' => '1122334455',
            'ngay_cap' => '2023-03-01',
            'noi_cap' => 'Đà Nẵng',
            'noi_kham_benh' => 'Bệnh viện C',
        ]);

        \App\Models\BaoHiemYte::create([
            'idbh' => 'BH00004',
            'ma_nv' => 'NV0004',
            'so_bao_hiem' => '6677889900',
            'ngay_cap' => '2023-04-01',
            'noi_cap' => 'Cần Thơ',
            'noi_kham_benh' => 'Bệnh viện D',
        ]);
    }
}
