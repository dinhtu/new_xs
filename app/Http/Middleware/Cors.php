<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (env('APP_DEBUG') && $request->header('Origin')) {
            $response
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Allow-Origin', $request->header('Origin'))
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Origin, Authorization, Accept, Content-Type, X-XSRF-Token')
                ->header('Access-Control-Expose-Headers', 'Authorization');
        }

        return $response;
    }
}