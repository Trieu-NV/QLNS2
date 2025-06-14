<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo dữ liệu cho các bảng cơ sở trước
        $this->call([
            ChucVuSeeder::class,
            PhongBanSeeder::class,
            TrinhDoSeeder::class,
            NhanSuSeeder::class,
            PhuCapSeeder::class,
            HopDongSeeder::class,
            BaoHiemYteSeeder::class,
            NhanVienPhuCapSeeder::class, // Added NhanVienPhuCapSeeder
        ]);

        // Tạo user mặc định
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // Add a default password
        ]);
    }
}
