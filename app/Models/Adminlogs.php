<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adminlogs extends Model
{
    use HasFactory;

    protected $table = "admin_logs";

    protected $primaryKey = "id";

    protected $fillable = [
        'admin_id',
        'table',
        'table_id',
        'action',
        'action_detail',
        'ipaddress',
        'created_by'
    ];

    public function admin()
    {
        return $this->belongsTo(Admins::class, 'admin_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo(Admins::class, 'created_by', 'id');
    }
}
