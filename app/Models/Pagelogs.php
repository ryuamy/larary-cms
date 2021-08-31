<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagelogs extends Model
{
    use HasFactory;

    protected $table = "page_logs";

    protected $primaryKey = "id";

    protected $fillable = [
        'admin_id',
        'page_id',
        'action',
        'action_detail',
        'ipaddress',
        'created_by'
    ];

    public function admin()
    {
        return $this->belongsTo(Admins::class, 'admin_id', 'id');
    }

    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo(Admins::class, 'created_by', 'id');
    }
}
