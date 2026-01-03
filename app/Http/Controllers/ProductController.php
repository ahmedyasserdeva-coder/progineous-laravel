<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of products (Homepage)
     */
    public function index()
    {
        $hostingProducts = Product::hosting()->active()->limit(3)->get();
        $domainProducts = Product::domains()->active()->limit(4)->get();
        $emailProducts = Product::email()->active()->limit(3)->get();

        return view('products.index', compact('hostingProducts', 'domainProducts', 'emailProducts'));
    }

    /**
     * Display hosting products
     */
    public function hosting()
    {
        $sharedHosting = Product::hosting()->where('category', 'shared_hosting')->active()->get();
        $cloudHosting = Product::hosting()->where('category', 'cloud_hosting')->active()->get();
        $vpsHosting = Product::hosting()->where('category', 'vps_hosting')->active()->get();
        $dedicatedServers = Product::hosting()->where('category', 'dedicated_server')->active()->get();
        $resellerHosting = Product::hosting()->where('category', 'reseller_hosting')->active()->get();

        return view('products.hosting', compact(
            'sharedHosting', 
            'cloudHosting', 
            'vpsHosting', 
            'dedicatedServers', 
            'resellerHosting'
        ));
    }

    /**
     * Display domain products
     */
    public function domains()
    {
        $domainProducts = Product::domains()->active()->get();
        
        return view('products.domains', compact('domainProducts'));
    }

    /**
     * Display email products
     */
    public function email()
    {
        $professionalEmail = Product::email()->where('category', 'professional_email')->active()->get();
        $emailSecurity = Product::email()->where('category', 'email_security')->active()->get();
        $emailMigration = Product::email()->where('category', 'migrate_email')->active()->get();

        return view('products.email', compact('professionalEmail', 'emailSecurity', 'emailMigration'));
    }

    /**
     * Display a specific product
     */
    public function show(Product $product)
    {
        // Load server relationship with nameservers
        $product->load('server');
        
        return view('products.show', compact('product'));
    }

    /**
     * Display professional email products
     */
    public function professionalEmail()
    {
        $products = Product::email()->where('category', 'professional_email')->active()->get();
        return view('products.professional-email', compact('products'));
    }

    /**
     * Display email security products
     */
    public function emailSecurity()
    {
        $products = Product::email()->where('category', 'email_security')->active()->get();
        return view('products.email-security', compact('products'));
    }

    /**
     * Display email migration services
     */
    public function emailMigration()
    {
        $products = Product::email()->where('category', 'migrate_email')->active()->get();
        return view('products.email-migration', compact('products'));
    }
}
