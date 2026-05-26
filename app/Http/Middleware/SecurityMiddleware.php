<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response{

          $response = $next($request);

        if(! $request->headers->has('Accept')
            || $request->headers->get('Accept')==='*/*'){

         $request->headers->set('Accept','application/json');
        }



        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        $response->headers->set('X-Frame-Options', 'DENY');

        $response->headers->set('X-Content-Type-Options', 'nosniff');

        $response->headers->set('Referrer-Policy',
            'no-referrer');

         $response->headers->set('X-permitted-cross-domain-policies', 'none');

        $response->headers->set('X-XSS-Protection', '1; mode=block');

        $response->headers->remove('X-Powered-By');

        $response->headers->set('Content-Security-Policy',
            "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';");

       header('Content-Disposition: attachment; filename="safe_name.pdf"');

            if(config('app.env') === 'production'){

        $response->headers->set('Strict-Transport-Security',
            'max-age=31536000; includeSubDomains; preload');
            }

        return $response;
    }
}
