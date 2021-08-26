<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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

        Validator::extend('idn_identity_number', function($attribute, $value, $validator) {
            //make sure to run IndonesiaProvinces and Indonesia Cities Seeder first
            $split_value = str_split($value, 2);
            $check_province = DB::table('provinces')->where('administration_code', $split_value[0])->first();
            if(!empty($check_province)) {
                $check_city = DB::table('cities')->where('administration_code', $split_value[1])->first();
            }
            return (!empty($check_province) && (isset($check_city) && !empty($check_city))) ? TRUE : FALSE;
        }, 'The :attribute invalid Indonesia identity number');

        Validator::extend('idn_driver_license', function($attribute, $value, $validator) {
            //make sure to run IndonesiaProvinces and Indonesia Cities Seeder first
            $split_value = str_split($value, 2);
            $check_province = DB::table('provinces')->where('administration_code', $split_value[2])->first();
            if(!empty($check_province)) {
                $check_city = DB::table('cities')->where('administration_code', $split_value[3])->first();
            }
            return (!empty($check_province) && (isset($check_city) && !empty($check_city))) ? TRUE : FALSE;
        }, 'The :attribute invalid Indonesia driver license');

        //Smart SIM
        Validator::extend('idn_driver_license_v2', function($attribute, $value, $validator) {
            //make sure to run IndonesiaProvinces and Indonesia Cities Seeder first
            $split_value = str_split($value, 2);
            $check_province = DB::table('provinces')->where('administration_code', $split_value[0])->first();
            if(!empty($check_province)) {
                $check_city = DB::table('cities')->where('administration_code', $split_value[1])->first();
            }
            return (!empty($check_province) || (isset($check_city) && !empty($check_city))) ? TRUE : FALSE;
        }, 'The :attribute invalid Indonesia driver license');

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
        }, 'The :attribute is not match with old password.');
    }
}
