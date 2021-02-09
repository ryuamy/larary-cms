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
        'ipaddress'
    ];

    public function admin_data()
    {
        return $this->belongsTo(Admins::class);
    }
}
