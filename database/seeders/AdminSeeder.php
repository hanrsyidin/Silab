<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'password' => Hash::make('admin123'), // ganti password sesuai kebutuhan
            'nim'      => 'adminUser', // sesuaikan NIM jika diperlukan
            'role'     => 0, // role admin
        ]);
    }
}
