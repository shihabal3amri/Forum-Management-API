<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    // A tag belongs to many posts (many-to-many relationship)
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
}

