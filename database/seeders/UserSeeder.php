<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa tài khoản cũ nếu có
        DB::table('users')->whereIn('username', ['admin', 'hr', 'totruong'])->delete();

        // Tạo tài khoản Admin (loaitk = 0)
        DB::table('users')->insert([
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'loaitk' => 0,
            'email' => 'admin@example.com',
            'sdt' => '0123456789',
            'info' => 'Tài khoản quản trị viên',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tạo tài khoản HR (loaitk = 1)
        DB::table('users')->insert([
            'username' => 'hr',
            'password' => Hash::make('123456'),
            'loaitk' => 1,
            'email' => 'hr@example.com',
            'sdt' => '0123456790',
            'info' => 'Tài khoản nhân sự',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tạo tài khoản Tổ trưởng (loaitk = 2)
        DB::table('users')->insert([
            'username' => 'totruong',
            'password' => Hash::make('123456'),
            'loaitk' => 2,
            'email' => 'totruong@example.com',
            'sdt' => '0123456791',
            'info' => 'Tài khoản tổ trưởng',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}