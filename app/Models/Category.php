<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    // A category belongs to many forums (many-to-many relationship)
    public function forums()
    {
        return $this->belongsToMany(Forum::class, 'forum_category');
    }

    // A category has many posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

