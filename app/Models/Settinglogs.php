<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settinglogs extends Model
{
    use HasFactory;

    protected $table = "setting_logs";

    protected $primaryKey = "id";

    protected $fillable = [
        'admin_id',
        'setting_id',
        'action',
        'action_detail',
        'ipaddress',
        'created_at',
        'updated_at'
    ];

    public function settings() {
        return $this->belongsTo(Settings::class);
    }
}
