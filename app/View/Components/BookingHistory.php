<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Booking;

class BookingHistory extends Component
{
    /**
     * Koleksi booking yang akan ditampilkan.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $bookings;

    public function __construct()
    {
        // Ambil semua booking, eager‐load relasi user dan laboratory
        $this->bookings = Booking::with(['user','laboratory'])
                                 ->orderByDesc('booking_time')
                                 ->get();
    }

    /**
     * Render komponen.
     */
    public function render()
    {
        return view('components.booking-history');
    }
}
