<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // إذا كان الطلب لـ client guard، نوجه للـ login
            if ($request->is('dashboard') || $request->is('dashboard/*') || 
                $request->is('profile') || $request->is('profile/*') ||
                $request->is('order/*') || $request->is('wallet/*') ||
                $request->is('settings') || $request->is('settings/*')) {
                return route('login');
            }
            
            return route('login');
        }
        
        return null;
    }
}
