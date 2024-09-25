<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Get paginated posts by forum and category with paginated comments and tags
    public function getPostsByForumAndCategory(Request $request, $forumId, $categoryId)
    {
        // Use query parameters to set pagination dynamically, or fall back to default values
        $postsPerPage = $request->query('postsPerPage', 10); // Default to 10 posts per page
        $commentsPerPage = $request->query('commentsPerPage', 5); // Default to 5 comments per post

        // Paginate posts dynamically based on the request
        $posts = Post::where('forum_id', $forumId)
            ->where('category_id', $categoryId)
            ->with(['tags', 'user']) // Load tags with posts
            ->paginate($postsPerPage); // Dynamically paginate posts

        // Paginate comments for each post
        $posts->getCollection()->transform(function ($post) use ($commentsPerPage) {
            $post->comments = $post->comments()->with('user')->paginate($commentsPerPage); // Dynamically paginate comments
            return $post;
        });

        return response()->json($posts);
    }

    // Get all posts created by a specific user with paginated comments, tags, and pagination
    public function getPostsByUser(Request $request, $userId)
    {
        // Use query parameters to set pagination dynamically, or fall back to default values
        $postsPerPage = $request->query('postsPerPage', 10); // Default to 10 posts per page
        $commentsPerPage = $request->query('commentsPerPage', 5); // Default to 5 comments per post

        // Paginate posts by user dynamically based on the request
        $posts = Post::where('user_id', $userId)
            ->with(['tags', 'forum', 'category', 'user']) // Load tags, forum, and category
            ->paginate($postsPerPage); // Dynamically paginate posts

        // Paginate comments for each post
        $posts->getCollection()->transform(function ($post) use ($commentsPerPage) {
            $post->comments = $post->comments()->with('user')->paginate($commentsPerPage); // Dynamically paginate comments
            return $post;
        });

        return response()->json($posts);
    }
}


