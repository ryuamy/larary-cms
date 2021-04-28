<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;
use Session;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if(Route::is('adm_*')){
                Session::flash('error-message', 'You don\'t have access');
                return route('adm_login');
            }

            return route('login');
        }
    }
}
