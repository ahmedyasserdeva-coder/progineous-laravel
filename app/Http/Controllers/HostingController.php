<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HostingController extends Controller
{
    /**
     * Display shared hosting page
     */
    public function shared()
    {
        $plans = Product::where('category', 'shared_hosting')
            ->where('is_active', true)
            ->orderBy('price', 'asc')
            ->get();
            
        return view('frontend.hosting.shared', compact('plans'));
    }

    /**
     * Display cloud hosting page
     */
    public function cloud()
    {
        $plans = Product::where('category', 'cloud_hosting')
            ->where('is_active', true)
            ->orderBy('price', 'asc')
            ->get();
            
        return view('frontend.hosting.cloud', compact('plans'));
    }

    /**
     * Display VPS hosting page
     */
    public function vps()
    {
        return view('frontend.hosting.vps');
    }

    /**
     * Display dedicated hosting page
     */
    public function dedicated()
    {
        return view('frontend.hosting.dedicated');
    }

    /**
     * Display reseller hosting page
     */
    public function reseller()
    {
        $plans = Product::where('category', 'reseller_hosting')
            ->where('is_active', true)
            ->orderBy('price', 'asc')
            ->get();
            
        return view('frontend.hosting.reseller', compact('plans'));
    }

    /**
     * Display hosting index page
     */
    public function index()
    {
        return view('frontend.hosting.index');
    }
}
