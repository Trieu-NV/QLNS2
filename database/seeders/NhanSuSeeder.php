<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NhanSu;
use App\Models\ChucVu;
use App\Models\PhongBan;
use App\Models\TrinhDo;
use Faker\Factory as Faker;

class NhanSuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');
        
        // Lấy ID của các bảng liên quan
        $chucVuIds = ChucVu::pluck('id')->toArray();
        $phongBanIds = PhongBan::pluck('id')->toArray();
        $trinhDoIds = TrinhDo::pluck('id')->toArray();
        
        // Danh sách tên Việt Nam
        $hoTens = [
            'Nguyễn Văn An', 'Trần Thị Bình', 'Lê Văn Cường', 'Phạm Thị Dung',
            'Hoàng Văn Em', 'Vũ Thị Phương', 'Đặng Văn Giang', 'Bùi Thị Hoa',
            'Ngô Văn Inh', 'Đinh Thị Kim', 'Lý Văn Long', 'Tạ Thị Mai',
            'Phan Văn Nam', 'Đỗ Thị Oanh', 'Chu Văn Phúc', 'Võ Thị Quỳnh',
            'Lưu Văn Rồng', 'Cao Thị Sương', 'Hồ Văn Tài', 'Dương Thị Uyên',
            'Trịnh Văn Vinh', 'Lại Thị Xuân', 'Mạc Văn Yên', 'Tôn Thị Zung',
            'Nguyễn Minh Anh', 'Trần Hoàng Bảo', 'Lê Thị Cẩm', 'Phạm Văn Đức',
            'Hoàng Thị Linh', 'Vũ Minh Tuấn', 'Đặng Thị Nga', 'Bùi Văn Hùng'
        ];
        
        // Tạo 50 nhân sự giả
        for ($i = 0; $i < 15; $i++) {
            NhanSu::create([
                'ma_nv' => 'NV' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'ho_ten' => $hoTens[array_rand($hoTens)],
                'gioi_tinh' => $faker->randomElement(['Nam', 'Nữ', 'Khác']),
                'ngay_sinh' => $faker->dateTimeBetween('-60 years', '-22 years')->format('Y-m-d'),
                'sdt' => '0' . $faker->numerify('#########'),
                'hinh_anh' => null,
                'dia_chi' => $faker->address,
                'id_chuc_vu' => $faker->randomElement($chucVuIds),
                'id_phong_ban' => $faker->randomElement($phongBanIds),
                'id_trinh_do' => $faker->randomElement($trinhDoIds),
                'trang_thai' => $faker->randomElement([true, false]),
            ]);
        }
    }
}