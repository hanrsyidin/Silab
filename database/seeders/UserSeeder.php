<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Ahmad Farhan Rasyidin',
            'password' => Hash::make('09021282328084'),
            'nim'      => '09021282328084',
        ]);
    }
}
