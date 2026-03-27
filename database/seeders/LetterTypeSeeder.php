<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LetterType;

class LetterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['id' => 11, 'letter_type' => 'Surat Masuk P1'],
            ['id' => 12, 'letter_type' => 'Surat Balasan P1'],
            ['id' => 21, 'letter_type' => 'Surat Masuk P2'],
            ['id' => 22, 'letter_type' => 'Surat Balasan P2'],
            ['id' => 23, 'letter_type' => 'Perjanjian Kerja Sama'],
            ['id' => 24, 'letter_type' => 'Form User'],
            ['id' => 25, 'letter_type' => 'BAST User'],
            ['id' => 26, 'letter_type' => 'Adendum'],
            ['id' => 31, 'letter_type' => 'Laporan Semester'],
            ['id' => 32, 'letter_type' => 'Data Balikan'],
            ['id' => 33, 'letter_type' => 'POC'],
            ['id' => 41, 'letter_type' => 'BAST Pergantian User Dukcapil'],
            ['id' => 42, 'letter_type' => 'Lainnya'],
        ];

        foreach ($types as $type) {
            LetterType::updateOrCreate(
                ['id' => $type['id']], // Kunci pencarian
                ['letter_type' => $type['letter_type']] // Data yang diupdate/input
            );
        }
    }
}
