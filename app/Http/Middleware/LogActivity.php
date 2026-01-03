<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log for authenticated users and non-GET requests
        $isAuthenticated = Auth::guard('client')->check() || Auth::guard('admin')->check() || Auth::guard('web')->check();
        
        if ($isAuthenticated && !$request->isMethod('GET')) {
            $this->logActivity($request, $response);
        }

        return $response;
    }

    /**
     * Log the activity.
     */
    protected function logActivity(Request $request, Response $response): void
    {
        try {
            $route = $request->route();
            $method = $request->method();
            $path = $request->path();
            $statusCode = $response->getStatusCode();

            // Skip logging for certain routes
            $skipRoutes = ['_debugbar', 'telescope', 'horizon'];
            foreach ($skipRoutes as $skipRoute) {
                if (str_contains($path, $skipRoute)) {
                    return;
                }
            }

            // Determine description based on route and method
            $description = $this->generateDescription($request, $method, $path);

            // Get authenticated user from any guard
            $user = Auth::guard('client')->user() 
                 ?? Auth::guard('admin')->user() 
                 ?? Auth::guard('web')->user();

            // Determine user type and ID
            $userId = null;
            $userType = null;
            if (Auth::guard('client')->check()) {
                $userId = Auth::guard('client')->id();
                $userType = 'App\\Models\\Client';
            } elseif (Auth::guard('admin')->check()) {
                $userId = Auth::guard('admin')->id();
                $userType = 'App\\Models\\Admin';
            } elseif (Auth::guard('web')->check()) {
                $userId = Auth::guard('web')->id();
                $userType = 'App\\Models\\User';
            }

            // Log to activity_logs table
            if ($userId && $userType) {
                DB::table('activity_logs')->insert([
                    'log_name' => 'default',
                    'causer_id' => $userId,
                    'causer_type' => $userType,
                    'event' => $request->method(),
                    'description' => $description,
                    'properties' => json_encode([
                        'method' => $request->method(),
                        'url' => $request->fullUrl(),
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'status_code' => $response->getStatusCode(),
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            // Silently fail to not disrupt the application
            Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }

    /**
     * Generate description based on request.
     */
    protected function generateDescription(Request $request, string $method, string $path): string
    {
        $route = $request->route();
        
        if ($route && $route->getName()) {
            $routeName = $route->getName();
            
            // Map route names to readable descriptions
            $descriptions = [
                'admin.system-settings.general.save' => 'Updated general settings',
                'admin.users.store' => 'Created a new user',
                'admin.users.update' => 'Updated user information',
                'admin.users.destroy' => 'Deleted a user',
                'login' => 'User logged in',
                'logout' => 'User logged out',
            ];

            if (isset($descriptions[$routeName])) {
                return $descriptions[$routeName];
            }
        }

        // Fallback to generic description
        return match($method) {
            'POST' => "Created resource at {$path}",
            'PUT', 'PATCH' => "Updated resource at {$path}",
            'DELETE' => "Deleted resource at {$path}",
            default => "Performed {$method} on {$path}",
        };
    }

    /**
     * Get log name based on path.
     */
    protected function getLogName(string $path): string
    {
        if (str_contains($path, 'admin/users')) return 'users';
        if (str_contains($path, 'admin/settings')) return 'settings';
        if (str_contains($path, 'admin/orders')) return 'orders';
        if (str_contains($path, 'admin/customers')) return 'customers';
        if (str_contains($path, 'login') || str_contains($path, 'logout')) return 'auth';
        
        return 'default';
    }
}
