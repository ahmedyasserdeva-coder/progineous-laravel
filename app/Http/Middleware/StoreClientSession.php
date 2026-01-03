<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreClientSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Update session with client ID if authenticated
        if (Auth::guard('client')->check()) {
            $sessionId = session()->getId();
            if ($sessionId) {
                DB::table('sessions')
                    ->where('id', $sessionId)
                    ->update([
                        'user_id' => Auth::guard('client')->id(),
                        'last_activity' => time()
                    ]);
            }
        }

        return $response;
    }
}
