<?php

namespace Database\Seeders;

use App\Models\Forum;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\User;
use App\Models\PrivateMessage;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    public function run()
    {
        // Fetch User One by email
        $userOne = User::where('email', 'userone@example.com')->first();
        $userTwo = User::where('email', 'usertwo@example.com')->first();

        // Create Forums
        $techForum = Forum::create(['name' => 'Tech Forum']);
        $gamingForum = Forum::create(['name' => 'Gaming Forum']);

        // Create Categories
        $generalCategory = Category::create(['name' => 'General Discussion']);
        $announcementsCategory = Category::create(['name' => 'Announcements']);
        $reviewsCategory = Category::create(['name' => 'Reviews']);

        // Link categories to forums
        $techForum->categories()->attach([$generalCategory->id, $announcementsCategory->id]);
        $gamingForum->categories()->attach([$generalCategory->id, $reviewsCategory->id]);

        // Create Tags
        $laravelTag = Tag::create(['name' => 'Laravel']);
        $phpTag = Tag::create(['name' => 'PHP']);
        $javascriptTag = Tag::create(['name' => 'JavaScript']);

        // Create Posts
        $post1 = Post::create([
            'forum_id' => $techForum->id,
            'category_id' => $generalCategory->id,
            'user_id' => $userOne->id,
            'content' => 'This is a post in Tech Forum General Discussion',
        ]);

        $post2 = Post::create([
            'forum_id' => $gamingForum->id,
            'category_id' => $generalCategory->id,
            'user_id' => $userOne->id,
            'content' => 'This is a post in Gaming Forum General Discussion',
        ]);

        // Attach tags to posts
        $post1->tags()->attach([$laravelTag->id, $phpTag->id]);
        $post2->tags()->attach([$javascriptTag->id]);

        // Create Comments
        Comment::create([
            'post_id' => $post1->id,
            'user_id' => $userTwo->id,
            'content' => 'Interesting post about Tech Forum',
        ]);

        Comment::create([
            'post_id' => $post2->id,
            'user_id' => $userTwo->id,
            'content' => 'Nice post in the Gaming Forum',
        ]);

        // Create Private Messages between users
        PrivateMessage::create([
            'sender_id' => $userOne->id,
            'receiver_id' => $userTwo->id,
            'message' => 'Hey, what do you think about Laravel?',
        ]);

        PrivateMessage::create([
            'sender_id' => $userTwo->id,
            'receiver_id' => $userOne->id,
            'message' => 'I think it’s awesome!',
        ]);
    }
}

