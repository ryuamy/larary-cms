<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultstringLength(191);

        //Custom validation rule.
        Validator::extend('idn_phone_number', function($attr, $value){
            return preg_match('/^(^\+62\s?|^0)(\d{2,4}-?){2}\d{3,5}$/', $value);
        });

        Validator::extend('alpha_spaces', function($attr, $value){
            return preg_match('/^[\pL\s]+$/u', $value);
        });

        Validator::extend('alpha_num_spaces', function($attr, $value){
            return preg_match('/^[a-zA-Z0-9\s]*$/', $value);
        });
    }
}
