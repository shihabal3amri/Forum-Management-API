<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['forum_id', 'category_id', 'user_id', 'content'];

    // A post belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A post belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // A post belongs to a forum
    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    // A post has many comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // A post belongs to many tags (many-to-many relationship)
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
}

