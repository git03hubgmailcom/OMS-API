<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('OPTIONS')) {
            return response()->json('', 200, [
                'Access-Control-Allow-Origin' => 'https://oms-app.vercel.app/',
                'Access-Control-Allow-Methods' => '*',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
            ]);
        }

        return $next($request)
            ->header('Access-Control-Allow-Origin', 'https://oms-app.vercel.app/')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

}
