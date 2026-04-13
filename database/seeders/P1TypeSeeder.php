<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\P1Type;

class P1TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['id' => 1, 'type_name' => 'Izin Baru'],
            ['id' => 2, 'type_name' => 'Perpanjangan'],
        ];

        foreach ($types as $type) {
            P1Type::updateOrCreate(
                ['id' => $type['id']], // Kunci pencarian
                ['type_name' => $type['type_name']] // Data yang diupdate/input
            );
        }
    }
}
