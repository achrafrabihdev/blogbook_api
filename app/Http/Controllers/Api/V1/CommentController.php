<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function store(Request $request,Post $post)
    {
        $comment = $post->comments()->create([
            'content' => $request->content,
            // 'user_id' =>$request->user()->id
            'user_id' => 1
        ]);
        return new CommentResource($comment);
    }
}
