<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userlogs extends Model
{
    use HasFactory;

    protected $table = "user_logs";

    protected $primaryKey = "id";

    protected $fillable = [
        'user_id',
        'table',
        'table_id',
        'action',
        'action_detail',
        'ipaddress',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo(Admins::class, 'created_by', 'id');
    }
}
