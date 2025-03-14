<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class LaboratoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $laboratories = [
            'A.1.1 Lab. Rekayasa Perangkat Lunak dan Sistem Informasi',
            'A.1.2 Lab. Pemrograman Internet',
            'A.1.3 Lab. Struktur Data dan Sistem Informasi Akuntansi',
            'A.1.4 Lab. Multimedia dan Pemrograman Game',
            'A.1.5 Lab. Basis Data dan Big Data',
            'A.2.1 Lab. Robotika, Sistem Kendali, dan Sistem Tertanam',
            'A.2.3 Lab. Perangkat Keras Komputer dan Teknologi Komponen',
            'A.2.4 Lab. Elektronika dan Sistem Digital',
            'A.2.5 Lab. Jaringan Komputer dan Komunikasi Data',
            'A.3.1 Lab. Kecerdasan Buatan dan Grafika Komputer',
            'A.3.2 Lab. Pengolahan Citra dan Pengenalan Pola',
            'A.3.3 Lab. Pemrograman Dasar',
            'A.3.4 Lab. Pemrograman Lanjut'
        ];
        
        $schedules = [
            '08.00 - 10.00',
            '10.30 - 12.39',
            '13.00 - 15.00'
        ];
        
        foreach ($laboratories as $lab) {
            foreach ($schedules as $schedule) {
                DB::table('laboratories')->insert([
                    'lab_name' => $lab,
                    'schedule' => $schedule,
                    'is_available' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}