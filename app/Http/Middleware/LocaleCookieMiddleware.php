<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleCookieMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->cookie('locale', app()->getLocale());
        app()->setLocale($locale);
        return $next($request);
    }
}
