<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $table = "tags";

    protected $primaryKey = "id";
    
    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'type',
        'status',
        'created_by',
        'updated_by'
    ];
}
