<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newslogs extends Model
{
    use HasFactory;

    protected $table = "news_logs";

    protected $primaryKey = "id";
    
    protected $fillable = [
        'admin_id',
        'news_id',
        'action',
        'action_detail',
        'ipaddress',
        'created_at',
        'updated_at'
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
