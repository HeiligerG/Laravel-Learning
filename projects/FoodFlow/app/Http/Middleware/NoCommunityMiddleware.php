<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCommunityMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->communities()->exists()) {
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
