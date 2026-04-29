<<<<<<< HEAD
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
=======
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
>>>>>>> 0d6f5c2c18f02c9c7d0a3cb40a1c8218e42ba08f
