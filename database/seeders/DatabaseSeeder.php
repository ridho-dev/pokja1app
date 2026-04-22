<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // BUAT ROLES 

        $roleAdmin = Role::create([
            'name' => 'Admin',
            'description' => 'Administrator Utama'
        ]);

        $rolePegawai = Role::create([
            'name' => 'Pegawai',
            'description' => 'Pegawai IDKD'
        ]);

        $roleTamu = Role::create([
            'name' => 'Tamu',
            'description' => 'Pengunjung'
        ]);

        // BUAT USER

        User::create([
            'name' => 'System',
            'username' => 'system',          
            'password' => Hash::make('system123'),
            'nip' => '000000000000000000',
            'role_id' => $roleAdmin->id, 
            'is_active' => true,
            'created_by' => null,
        ]);

        User::create([
            'name' => 'Ridho Steven Paian Pardede',
            'username' => 'ridho',
            'password' => Hash::make('12345678'),
            'nip' => '200108272025041001',
            'role_id' => $rolePegawai->id,
            'is_active' => true,
            'created_by' => 1, 
        ]);

        User::create([
            'name' => 'Fahriza Amirul Hakim',
            'username' => 'fahriza',
            'password' => Hash::make('12345678'),
            'nip' => '199905022022081001',
            'role_id' => $rolePegawai->id,
            'is_active' => true,
            'created_by' => 1, 
        ]);

        User::create([
            'name' => 'AA Azhari',
            'username' => 'ari',
            'password' => Hash::make('12345678'),
            'nip' => '198611012010121001',
            'role_id' => $rolePegawai->id,
            'is_active' => true,
            'created_by' => 1, 
        ]);

        User::create([
            'name' => 'Yuning Sri Harjanti',
            'username' => 'yuning',
            'password' => Hash::make('12345678'),
            'nip' => '197106031996032001',
            'role_id' => $rolePegawai->id,
            'is_active' => true,
            'created_by' => 1, 
        ]);

        User::create([
            'name' => 'Martina Elisabet Br Situmorang',
            'username' => 'martina',
            'password' => Hash::make('12345678'),
            'nip' => '198710092009122001',
            'role_id' => $rolePegawai->id,
            'is_active' => true,
            'created_by' => 1, 
        ]);

        User::create([
            'name' => 'Noer Endah Islami',
            'username' => 'endah',
            'password' => Hash::make('12345678'),
            'nip' => '199312052020122016',
            'role_id' => $rolePegawai->id,
            'is_active' => true,
            'created_by' => 1, 
        ]);

        User::create([
            'name' => 'Ratu Nur Asyifa',
            'username' => 'ratu',
            'password' => Hash::make('12345678'),
            'nip' => '199503232025212023',
            'role_id' => $rolePegawai->id,
            'is_active' => true,
            'created_by' => 1, 
        ]);

        User::create([
            'name' => 'Irma Suci Soraya',
            'username' => 'irma',
            'password' => Hash::make('12345678'),
            'nip' => '198411012025212017',
            'role_id' => $rolePegawai->id,
            'is_active' => true,
            'created_by' => 1, 
        ]);

        User::create([
            'name' => 'Wisnu Adi Nugroho',
            'username' => 'wisnu',
            'password' => Hash::make('12345678'),
            'nip' => '197802272001121001',
            'role_id' => $rolePegawai->id,
            'is_active' => true,
            'created_by' => 1, 
        ]);

        // ---------------------------------------------
        // SEEDER EKSTERNAL
        // ---------------------------------------------

        $this->call([
            ProvinceSeeder::class,
            RegencySeeder::class, 
            OpdSeeder::class,
            LetterTypeSeeder::class,
            P1TypeSeeder::class,
        ]);
    }
}
