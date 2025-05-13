<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clown;

class ClownController extends Controller
{
    public function getClowns() {
        $clowns = Clown::get();
        return $clowns;
    }
}
