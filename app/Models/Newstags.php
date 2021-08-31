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
        return $this->belongsTo(News::class, 'news_id', 'id');
    }

    public function tag()
    {
        return $this->belongsTo(Tags::class, 'tag_id', 'id');
    }

    public function created_by() {
        return $this->belongsTo(Admins::class, 'created_by', 'id');
    }

    public function updated_by() {
        return $this->belongsTo(Admins::class, 'updated_by', 'id');
    }
}
