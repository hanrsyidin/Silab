<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_name',
        'schedule',
        'is_available',
    ];

    // Tambahkan relasi ke Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'laboratory_id');
    }
}
