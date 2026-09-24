<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Mencegah clickjacking attacks
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Mencegah MIME-type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Mengaktifkan filter XSS di browser jadul
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Batasi pengiriman referer header
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Batasi akses fitur peramban yang tidak dibutuhkan (kamera, mikrofon, geolokasi)
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        return $response;
    }
}
