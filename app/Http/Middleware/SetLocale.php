<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);
        
        // Check if the first segment is a valid locale
        if (in_array($locale, ['ar', 'en'])) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // If no locale in URL, use session or default to English
            $locale = Session::get('locale', 'en');
            App::setLocale($locale);
        }

        return $next($request);
    }
}
