<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newscategories extends Model
{
    use HasFactory;

    protected $table = "news_categories";

    protected $primaryKey = "id";
    
    protected $fillable = [
        'news_id',
        'category_id',
        'status',
        'created_by',
        'updated_by'
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
