<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $table = "settings";

    protected $primaryKey = "id";

    protected $fillable = [
        'meta_key',
        'meta_value',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function logs() {
        return $this->hasMany(Settinglogs::class);
    }

    // List of statuses
    const IS_INACTIVE = 0;
    const IS_ACTIVE = 1;
}
