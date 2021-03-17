<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        Validator::extend('idn_phone_number', function($attribute, $value) {
            return preg_match('/^(^\+62\s?|^0)(\d{2,4}-?){2}\d{3,5}$/', $value);
        }, 'The :attribute invalid Indonesia phone number.');

        Validator::extend("idn_address", function($attribute, $value) {
            return preg_match('/^[a-zA-Z0-9-_,.\s]*$/', $value);
        }, 'The :attribute invalid Indonesia address.');

        Validator::extend('alpha_spaces', function($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);
        }, 'The :attribute may only contain letters and spaces.');

        Validator::extend('alpha_num_spaces', function($attribute, $value) {
            return preg_match('/^[a-zA-Z0-9\s]*$/', $value);
        }, 'The :attribute may only contain letters, numbers and spaces.');

        Validator::extend('slug', function($attribute, $value) {
            return preg_match('/^[a-zA-Z0-9-_]+$/', $value);
        }, 'The :attribute may only contain letters, numbers, dashes and underscores.');

        Validator::extend('old_password', function($attribute, $value, $parameters, $validator) {
            $user = DB::table('users')->where('uuid', $parameters)->first();
            if(empty($user)) {
                $user = DB::table('admins')->where('uuid', $parameters)->first();
            }
            return Hash::check($value, $user->password);
        }, 'The :attribute is not match with old password');
    }
}
