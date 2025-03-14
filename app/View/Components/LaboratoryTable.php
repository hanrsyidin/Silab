<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Laboratory;

class LaboratoryTable extends Component
{
    public $laboratories;

    public function __construct()
    {
        $this->laboratories = Laboratory::orderBy('lab_name')->orderBy('schedule')->get();
    }

    public function render()
    {
        return view('components.laboratory-table');
    }
}
