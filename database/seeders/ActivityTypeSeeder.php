<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $activities = [
            [
                'id'            => 1,
                'activity_type' => 'membuat',
            ],
            [
                'id'            => 2,
                'activity_type' => 'mengubah',
            ],
            [
                'id'            => 3,
                'activity_type' => 'menghapus',
            ],
        ];

        // Memasukkan data ke dalam tabel activity_types
        DB::table('activity_types')->insert($activities);
    }
}
