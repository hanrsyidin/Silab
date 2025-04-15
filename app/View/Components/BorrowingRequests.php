<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Models\Booking;

class BorrowingRequests extends Component
{
    // public $requests;
    public $bookings;

    public function __construct()
    {
        // $this->requests = Booking::where('response_admin', null)
        //                           ->with('user') // asumsi relasi booking ke user
        //                           ->get();

        $this->bookings = Booking::with('user', 'laboratory')
                                  ->whereNull('response_admin')
                                  ->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.borrowing-requests');
    }
}
