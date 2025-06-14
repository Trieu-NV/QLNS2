<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PhongBan;

class PhongBanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phongBans = [
            [
                'ten_phong_ban' => 'Phòng Nhân sự',
                'mo_ta' => 'Quản lý nhân sự, tuyển dụng, đào tạo và phát triển nguồn nhân lực'
            ],
            [
                'ten_phong_ban' => 'Phòng Kế toán',
                'mo_ta' => 'Quản lý tài chính, kế toán và báo cáo tài chính của công ty'
            ],
            [
                'ten_phong_ban' => 'Phòng Kinh doanh',
                'mo_ta' => 'Phát triển thị trường, bán hàng và chăm sóc khách hàng'
            ],
            [
                'ten_phong_ban' => 'Phòng Kỹ thuật',
                'mo_ta' => 'Nghiên cứu, phát triển sản phẩm và hỗ trợ kỹ thuật'
            ],
            [
                'ten_phong_ban' => 'Phòng Marketing',
                'mo_ta' => 'Xây dựng thương hiệu, quảng cáo và truyền thông'
            ],
            [
                'ten_phong_ban' => 'Phòng Hành chính',
                'mo_ta' => 'Quản lý hành chính, văn phòng và hỗ trợ chung'
            ],
            [
                'ten_phong_ban' => 'Phòng IT',
                'mo_ta' => 'Quản lý hệ thống thông tin, phát triển phần mềm và hỗ trợ công nghệ'
            ]
        ];

        foreach ($phongBans as $phongBan) {
            PhongBan::create($phongBan);
        }
    }
}