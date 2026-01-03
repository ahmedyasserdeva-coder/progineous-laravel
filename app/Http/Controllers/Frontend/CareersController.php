<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CareersController extends Controller
{
    /**
     * Display the careers page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.careers.index');
    }
}
