<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use App\Models\Category;
use App\Models\Location;
use Illuminate\View\Component;

class Search extends Component
{
    public $categories;
    public $locations;

    public function __construct($categories, $locations)
    {
        $this->categories = $categories;
        $this->locations = $locations;
    }

    public function render()
    {
        return view('components.search');
    }
}
