<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
    
        if (!$query) {
            return response()->json(['message' => 'Query is required'], 400);
        }
    
        // Format the query for PostgreSQL full-text search
        $searchQuery = implode(' & ', explode(' ', $query)); // Converts "keyword1 keyword2" into "keyword1 & keyword2"
    
        // Full-text search in posts
        $posts = Post::whereRaw("to_tsvector('english', content) @@ to_tsquery(?)", [$searchQuery])
            ->with('comments')
            ->get();
    
        // Full-text search in comments
        $comments = Comment::whereRaw("to_tsvector('english', content) @@ to_tsquery(?)", [$searchQuery])
            ->with('post')
            ->get();
    
        return response()->json([
            'posts' => $posts,
            'comments' => $comments,
        ]);
    }
}

