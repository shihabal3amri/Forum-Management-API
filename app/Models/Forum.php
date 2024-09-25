<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = ['name'];

    // A forum has many categories (many-to-many relationship)
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'forum_category');
    }
}

