<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function myPosts()
    {
        $posts = Post::where('user_id',Auth::user()->id)->with('category','user')->get();
        return PostResource::collection($posts);
    }
}
