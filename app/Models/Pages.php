<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    protected $table = "Pages";

    protected $primaryKey = "id";

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'content',
        'featured_image',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function logs() {
        return $this->hasMany(Pagelogs::class);
    }

    public function admin() {
        return $this->belongsTo(Admins::class);
    }

    // List of statuses
    const IS_ACTIVE = 1;
    const IS_INACTIVE = 0;
    const IS_DELETED = -1;
}
