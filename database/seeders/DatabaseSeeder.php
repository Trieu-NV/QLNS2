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
        $this->call([
            ChucVuSeeder::class,
            PhongBanSeeder::class,
            TrinhDoSeeder::class,
            PhuCapSeeder::class,
            NhanSuSeeder::class,
            HopDongSeeder::class,
            BaoHiemYteSeeder::class,
            NhanVienPhuCapSeeder::class,
            UserSeeder::class,
        ]);
    }
}
