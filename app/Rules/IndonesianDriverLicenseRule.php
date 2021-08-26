<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class IndonesianDriverLicenseRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     * Make sure to run IndonesiaProvinces and Indonesia Cities Seeder first
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $split_value = str_split($value, 2);
        $check_province = DB::table('provinces')->where('administration_code', $split_value[2])->first();
        if(!empty($check_province)) {
            $check_city = DB::table('cities')->where('administration_code', $split_value[3])->first();
        }
        return (!empty($check_province) && (isset($check_city) && !empty($check_city))) ? TRUE : FALSE;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute invalid Indonesia driver license.';
    }
}
