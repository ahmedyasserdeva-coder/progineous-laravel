<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AccessLog;
use Symfony\Component\HttpFoundation\Response;

class CheckSiteAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip access check for specific routes
        $exemptPaths = [
            'access',
            'lang',
            'currency', 
            'unleasha',
        ];

        // Check if current path starts with any exempt path
        $currentPath = trim($request->getPathInfo(), '/');
        foreach ($exemptPaths as $exemptPath) {
            if (str_starts_with($currentPath, $exemptPath)) {
                return $next($request);
            }
        }

        $ipAddress = $request->ip();
        
        // Check if IP has access granted
        if (AccessLog::hasAccess($ipAddress)) {
            return $next($request);
        }

        // Log the access request
        AccessLog::logRequest($request);

        // Redirect to access request page
        return redirect()->route('access.request');
    }
}
