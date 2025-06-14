<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NhanVienPhuCap;
use App\Models\NhanSu;
use App\Models\PhuCap;
use Illuminate\Support\Facades\DB;

class NhanVienPhuCapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure NhanSu and PhuCap tables have data before seeding NhanVienPhuCap
        if (NhanSu::count() == 0) {
            $this->command->info('Table nhan_su is empty. Running NhanSuSeeder...');
            $this->call(NhanSuSeeder::class);
        }

        if (PhuCap::count() == 0) {
            $this->command->info('Table phu_cap is empty. Running PhuCapSeeder...');
            $this->call(PhuCapSeeder::class);
        }

        $nhanSus = NhanSu::pluck('ma_nv')->toArray();
        $phuCaps = PhuCap::pluck('id')->toArray();

        if (empty($nhanSus) || empty($phuCaps)) {
            $this->command->error('Cannot seed NhanVienPhuCap. NhanSu or PhuCap table is empty even after attempting to seed them.');
            return;
        }

        $data = [];
        $numberOfEntries = min(count($nhanSus), count($phuCaps), 5); // Seed at most 5 entries or available data

        for ($i = 0; $i < $numberOfEntries; $i++) {
            $data[] = [
                'ma_nv' => $nhanSus[array_rand($nhanSus)], // Pick a random NhanSu
                'id_phu_cap' => $phuCaps[array_rand($phuCaps)], // Pick a random PhuCap
                'ghi_chu' => 'Ghi chú mẫu ' . ($i + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        // Remove duplicates based on composite key before inserting
        $uniqueData = [];
        $existingPairs = [];
        foreach ($data as $item) {
            $pair = $item['ma_nv'] . '-' . $item['id_phu_cap'];
            if (!in_array($pair, $existingPairs)) {
                $uniqueData[] = $item;
                $existingPairs[] = $pair;
            }
        }

        if (!empty($uniqueData)) {
            DB::table('nhan_vien_phu_cap')->insert($uniqueData);
            $this->command->info(count($uniqueData) . ' NhanVienPhuCap records seeded successfully.');
        } else {
            $this->command->info('No new unique NhanVienPhuCap records to seed.');
        }
    }
}