<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            ['id' => 11, 'name' => 'Aceh'],
            ['id' => 12, 'name' => 'Sumatera Utara'],
            ['id' => 13, 'name' => 'Sumatera Barat'],
            ['id' => 14, 'name' => 'Riau'],
            ['id' => 15, 'name' => 'Jambi'],
            ['id' => 16, 'name' => 'Sumatera Selatan'],
            ['id' => 17, 'name' => 'Bengkulu'],
            ['id' => 18, 'name' => 'Lampung'],
            ['id' => 19, 'name' => 'Bangka Belitung'],
            ['id' => 21, 'name' => 'Kepulauan Riau'],
        ];

        foreach ($provinces as $province) {
            Province::updateOrCreate(
                ['id' => $province['id']], // Kunci pencarian
                ['name' => $province['name']] // Data yang disimpan/diupdate
            );
        }
    }
}
