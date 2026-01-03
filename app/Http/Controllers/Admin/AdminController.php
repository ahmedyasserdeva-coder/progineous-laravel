<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Domain;
use App\Models\HostingAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_domains' => Domain::count(),
            'total_hosting_accounts' => HostingAccount::count(),
        ];

        return view('admin.dashboard', compact('stats', 'admin'));
    }
}
