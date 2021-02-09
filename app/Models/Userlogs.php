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
        'ipaddress'
    ];

    public function user_data()
    {
        return $this->belongsTo(Users::class);
    }
}
