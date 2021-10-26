<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    use HasFactory;

    protected $table = "provinces";

    protected $primaryKey = "id";

    protected $fillable = [
        'country_id',
        'uuid',
        'name',
        'slug',
        'administration_code',
        'status',
        'created_by',
        'updated_by'
    ];

    public function country() {
        return $this->belongsTo(Countries::class, 'country_id', 'id');
    }

    public function cities() {
        return $this->hasMany(Cities::class, 'province_id', 'id');
    }
}
