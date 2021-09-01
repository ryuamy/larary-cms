<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adminrolemodules extends Model
{
    use HasFactory;

    protected $table = "admin_role_modules";

    protected $primaryKey = "id";

    protected $fillable = [
        'admin_id',
        'admin_role_id',
        'module_id',
        'module_slug',
        'rules',
        'created_by'
    ];

    public function admin()
    {
        return $this->belongsTo(Admins::class, 'admin_id', 'id');
    }

    public function admin_role()
    {
        return $this->belongsTo(Adminroles::class, 'admin_role_id', 'id');
    }

    public function module()
    {
        return $this->belongsTo(Modules::class, 'module_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo(Admins::class, 'created_by', 'id');
    }
}
