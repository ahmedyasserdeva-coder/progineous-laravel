<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetUserLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated - check all guards
        $user = auth('client')->user() 
             ?? auth('admin')->user() 
             ?? auth('web')->user();
        
        if ($user) {
            // Set locale from user's preferred language
            if (isset($user->preferred_language) && $user->preferred_language) {
                app()->setLocale($user->preferred_language);
                session()->put('locale', $user->preferred_language);
            }
        }
        
        return $next($request);
    }
}
