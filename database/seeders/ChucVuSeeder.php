<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChucVu;

class ChucVuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chucVus = [
            [
                'ten_chuc_vu' => 'Giám đốc',
                'mo_ta' => 'Người đứng đầu công ty, chịu trách nhiệm về toàn bộ hoạt động kinh doanh'
            ],
            [
                'ten_chuc_vu' => 'Phó Giám đốc',
                'mo_ta' => 'Hỗ trợ Giám đốc trong việc điều hành công ty'
            ],
            [
                'ten_chuc_vu' => 'Trưởng phòng',
                'mo_ta' => 'Quản lý và điều hành các hoạt động của phòng ban'
            ],
            [
                'ten_chuc_vu' => 'Phó trưởng phòng',
                'mo_ta' => 'Hỗ trợ trưởng phòng trong công tác quản lý'
            ],
            [
                'ten_chuc_vu' => 'Trưởng nhóm',
                'mo_ta' => 'Quản lý và điều phối công việc của nhóm'
            ],
            [
                'ten_chuc_vu' => 'Nhân viên',
                'mo_ta' => 'Thực hiện các công việc được giao theo chuyên môn'
            ],
            [
                'ten_chuc_vu' => 'Thực tập sinh',
                'mo_ta' => 'Học tập và thực hành công việc dưới sự hướng dẫn'
            ]
        ];

        foreach ($chucVus as $chucVu) {
            ChucVu::create($chucVu);
        }
    }
}