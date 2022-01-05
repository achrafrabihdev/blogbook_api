<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function index()
    {
        $posts = Post::with('user','category')->get();
        return PostResource::collection($posts);
    }

    public function store(Request $request)
    {
        if($request->hasFile('image')){
            $path = $request->file('image')->store('posts');
        }
        $post = Post::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title'),'-'),
            'content' => $request->input('content'),
            'image' => $path,
            'category_id' => $request->input('category_id'),
            'user_id' => $request->user()->id,
            // 'user_id' => 1,
            'nbr_views' => 0
        ]);
        return new PostResource($post);
    }

    public function show($slug)
    {
        $post = Post::where('slug',$slug)->with('user','category','comments')->first();
        return new PostResource($post);
    }

    public function update(Request $request, $slug)
    {
        $post = Post::where('slug',$slug)->first();
        if($request->hasFile('image')){
            $path = $request->file('image')->store('posts');
            Storage::delete($post->image);
        }
        $post->update([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title'),'-'),
            'content' => $request->input('content'),
            'image' => $path,
            'category_id' => $request->input('category_id'),
        ]);
        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->noContent();
    }

    public function viewIncrement($slug) {
        $post = Post::where('slug',$slug)->first();
        $post->nbr_views += 1;
        $post->save();
        return new PostResource($post);
    }

    public function getPostsByCategory(Category $category) {
        $posts = Post::where('category_id',$category->id)->with('user','category')->get();
        return PostResource::collection($posts);
    }

    public function mostPopularPosts(){
        $posts = Post::orderBy("nbr_views","desc")->take(5)->get();
        return PostResource::collection($posts);
    }

    public function mostActivePosts(){
        $posts = Post::withCount('comments')->orderBy('comments_count')->take(5)->get();
        return PostResource::collection($posts);
    }
}
