<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;

    protected $table = "cities";

    protected $primaryKey = "id";

    protected $fillable = [
        'country_id',
        'province_id',
        'uuid',
        'name',
        'slug',
        'administration_code',
        'postcode',
        'area_level',
        'status',
        'created_by',
        'updated_by'
    ];

    public function country() {
        return $this->belongsTo(Countries::class, 'country_id', 'id');
    }

    public function province() {
        return $this->belongsTo(Provinces::class, 'province_id', 'id');
    }
}
