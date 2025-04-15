<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'laboratory_id',
        'purpose',
        'lecture_name',
        'schedule',
        'booking_time',
        'response_admin',
    ];

    // Relasi ke Laboratory
    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class, 'laboratory_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
