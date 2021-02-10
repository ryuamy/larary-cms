<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
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
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // echo $guard; exit;
                if($guard == "admin"){
                    //user was authenticated with admin guard.
                    return redirect()->route('admin.dashboard');
                } else {
                    //default guard.
                    // return redirect()->route('home');
                    return redirect(RouteServiceProvider::HOME);
                }
            }
            // echo $guard.'x'; exit;
        }

        return $next($request);
    }
}
