<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

    protected $table = "countries";

    protected $primaryKey = "id";

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'iso_alpha_2_code',
        'iso_alpha_3_code',
        'un_code',
        'phone_code',
        'flag',
        'capital_city',
        'enable_multilanguage',
        'show_multilanguage',
        'status',
        'created_by',
        'updated_by'
    ];
}
