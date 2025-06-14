<?php

namespace Database\Seeders;

use App\Models\PhuCap;
use Illuminate\Database\Seeder;

class PhuCapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phuCaps = [
            [
                'phu_cap_name' => 'Phụ cấp ăn trưa',
                'so-tien' => 800000,
                'mo-ta' => 'Phụ cấp ăn trưa hàng tháng'
            ],
            [
                'phu_cap_name' => 'Phụ cấp xăng xe',
                'so-tien' => 300000,
                'mo-ta' => 'Phụ cấp đi lại hàng tháng'
            ],
            [
                'phu_cap_name' => 'Phụ cấp nhà ở',
                'so-tien' => 500000,
                'mo-ta' => 'Phụ cấp cước điện thoại hàng tháng'
            ],
            [
                'phu_cap_name' => 'Phụ cấp độc hại',
                'so-tien' => 1000000,
                'mo-ta' => 'Phụ cấp cho công việc độc hại'
            ],
            [
                'phu_cap_name' => 'Phụ cấp trách nhiệm',
                'so-tien' => 2000000,
                'mo-ta' => 'Phụ cấp cho vị trí quản lý'
            ]
        ];

        foreach ($phuCaps as $phuCap) {
            PhuCap::create($phuCap);
        }
    }
}
