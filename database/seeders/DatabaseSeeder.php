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
            'name' => 'Pegawai IDKD',
            'username' => 'Pegawai',
            'password' => Hash::make('pegawai123'),
            'nip' => '999999999999999999',
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
        ]);
    }
}
