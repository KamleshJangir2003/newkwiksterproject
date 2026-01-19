<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$guards): \Illuminate\Http\Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // If the guard is 'web', redirect to the home route
                if ($guard == 'web') {
                    return redirect(RouteServiceProvider::HOME);
                }
                // If the guard is 'admin', redirect to the admin dashboard route
                elseif ($guard == 'admin') {
                    return redirect()->route('admin.dashboard');
                }
            }
        }

        return $next($request);
    }
}