<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'info' => 'Administrator',
            'email' => 'admin@example.com',
            'sdt' => '0123456789',
            'loaitk' => 0, // admin
        ]);

        User::create([
            'username' => 'manager',
            'password' => Hash::make('123456'),
            'info' => 'Quản lý',
            'email' => 'manager@example.com',
            'sdt' => '0987654321',
            'loaitk' => 1, // quản lý
        ]);

        User::create([
            'username' => 'user',
            'password' => Hash::make('123456'),
            'info' => 'Người dùng',
            'email' => 'user@example.com',
            'sdt' => '0369852147',
            'loaitk' => 2, // người dùng
        ]);
    }
}