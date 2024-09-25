<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrivateMessageController;
use App\Http\Controllers\SearchController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/forums', [ForumController::class, 'getAllForumsWithCategories']);
    Route::get('/forums/{forum}/categories/{category}/posts', [PostController::class, 'getPostsByForumAndCategory']);
    Route::get('/users/{user}/posts', [PostController::class, 'getPostsByUser']);
    Route::get('/messages', [PrivateMessageController::class, 'getMessagesForUser']);
    Route::get('/search', [SearchController::class, 'search']);
});
