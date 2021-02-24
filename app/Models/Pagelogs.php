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
        'uuid',
        'name',
        'slug',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function page()
    {
        return $this->belongsTo(Pages::class);
    }
}
