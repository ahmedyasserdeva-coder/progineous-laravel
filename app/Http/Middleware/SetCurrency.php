<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetCurrency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currency = $request->get('currency');
        
        if ($currency && in_array($currency, ['USD', 'EGP'])) {
            Session::put('currency', $currency);
        } elseif (!Session::has('currency')) {
            // Default currency based on locale
            $locale = app()->getLocale();
            $defaultCurrency = $locale === 'ar' ? 'EGP' : 'USD';
            Session::put('currency', $defaultCurrency);
        }

        return $next($request);
    }
}
