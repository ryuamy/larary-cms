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
        'updated_by'
    ];

    public function admins()
    {
        return $this->hasMany(Admins::class, 'id', 'role_id');
    }

    public function modules()
    {
        return $this->hasMany(Adminrolemodules::class, 'id', 'admin_role_id');
    }

    public function created_by() {
        return $this->belongsTo(Admins::class, 'created_by', 'id');
    }

    public function updated_by() {
        return $this->belongsTo(Admins::class, 'updated_by', 'id');
    }

    // List of statuses
    const IS_INACTIVE = 0;
    const IS_ACTIVE = 1;
}
