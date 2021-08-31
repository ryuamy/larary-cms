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
        return $this->belongsTo(News::class, 'news_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo(Admins::class, 'created_by', 'id');
    }

    public function updated_by() {
        return $this->belongsTo(Admins::class, 'updated_by', 'id');
    }
}
