<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin@klinik.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Klinik',
            'email' => 'petugas@klinik.test',
            'password' => 'password',
            'role' => 'petugas',
        ]);
    }   
}
