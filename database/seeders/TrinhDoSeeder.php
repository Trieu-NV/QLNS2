<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TrinhDo;

class TrinhDoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trinhDos = [
            [
                'ten_trinh_do' => 'Tiến sĩ',
                'mo_ta' => 'Bằng tiến sĩ (PhD) - Trình độ học vấn cao nhất'
            ],
            [
                'ten_trinh_do' => 'Thạc sĩ',
                'mo_ta' => 'Bằng thạc sĩ (Master) - Trình độ sau đại học'
            ],
            [
                'ten_trinh_do' => 'Đại học',
                'mo_ta' => 'Bằng cử nhân đại học - Trình độ đại học'
            ],
            [
                'ten_trinh_do' => 'Cao đẳng',
                'mo_ta' => 'Bằng tốt nghiệp cao đẳng - Trình độ cao đẳng'
            ],
            [
                'ten_trinh_do' => 'Trung cấp',
                'mo_ta' => 'Bằng tốt nghiệp trung cấp nghề'
            ],
            [
                'ten_trinh_do' => 'Trung học phổ thông',
                'mo_ta' => 'Bằng tốt nghiệp trung học phổ thông (THPT)'
            ],
            [
                'ten_trinh_do' => 'Trung học cơ sở',
                'mo_ta' => 'Bằng tốt nghiệp trung học cơ sở (THCS)'
            ]
        ];

        foreach ($trinhDos as $trinhDo) {
            TrinhDo::create($trinhDo);
        }
    }
}