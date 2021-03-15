<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newstags extends Model
{
    use HasFactory;

    protected $table = "news_tags";

    protected $primaryKey = "id";
    
    protected $fillable = [
        'news_id',
        'tag_id',
        'status',
        'created_by',
        'updated_by'
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
