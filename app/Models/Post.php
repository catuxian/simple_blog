<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'title',
        'content',
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }
}