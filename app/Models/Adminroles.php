<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adminroles extends Model
{
    use HasFactory;

    protected $table = "admin_roles";

    protected $primaryKey = "id";
    
    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function admins()
    {
        return $this->hasMany(Admins::class);
    }

    // List of statuses
    const IS_INACTIVE = 0;
    const IS_ACTIVE = 1;
    const IS_DELETED = 2;
}
