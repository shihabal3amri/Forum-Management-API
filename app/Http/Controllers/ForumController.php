<?php

// app/Http/Controllers/ForumController.php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function getAllForumsWithCategories(Request $request)
    {
        $forums = Forum::with('categories')->paginate(10); // Paginate with 10 per page

        return response()->json($forums);
    }
}

