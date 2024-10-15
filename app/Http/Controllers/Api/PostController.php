<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource; // pastikan penulisan resource benar

class PostController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index()
    {
        //get all posts
        $posts = Post::latest()->paginate(5);

        //return collection of posts as a resource
        return PostResource::collection($posts);
    }
}
