<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;

    protected $table = 'laboratories'; // Nama tabel

    protected $fillable = [
        'lab_name',
        'schedule',
        'is_available',
    ];
}