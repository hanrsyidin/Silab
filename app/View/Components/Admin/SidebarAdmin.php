<?php

namespace App\View\Components\Admin;
use App\Models\Booking;
use Illuminate\View\Component;

class SidebarAdmin extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.admin.sidebar-admin');
    }
}
