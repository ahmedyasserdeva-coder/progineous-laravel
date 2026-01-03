<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only apply CSP to HTML responses
        $contentType = $response->headers->get('Content-Type', '');
        if (str_contains($contentType, 'text/html') || empty($contentType)) {
            // Content Security Policy - Explicitly set all directives
            $csp = [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://challenges.cloudflare.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://widget.intercom.io https://js.intercomcdn.com https://app.fawaterk.com https://staging.fawaterk.com",
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net https://app.fawaterk.com https://staging.fawaterk.com",
                "img-src 'self' data: https: blob:",
                "font-src 'self' data: https://fonts.gstatic.com https://cdn.jsdelivr.net",
                "connect-src 'self' https://challenges.cloudflare.com https://cdn.jsdelivr.net https://api-iam.intercom.io https://api.intercom.io https://nexus-websocket-a.intercom.io wss://nexus-websocket-a.intercom.io https://app.fawaterk.com https://staging.fawaterk.com https://web-console.hetzner.cloud wss://web-console.hetzner.cloud",
                "frame-src https://challenges.cloudflare.com https://www.intercom-messenger.com https://app.fawaterk.com https://staging.fawaterk.com",
                "worker-src 'self' blob:",
                "media-src 'self' blob: https:",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self' https://app.fawaterk.com https://staging.fawaterk.com",
            ];

            $response->headers->set('Content-Security-Policy', implode('; ', $csp));
        }

        // Other security headers (apply to all responses)
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(self), microphone=(), camera=()');

        return $response;
    }
}
