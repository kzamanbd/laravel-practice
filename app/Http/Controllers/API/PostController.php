<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index()
    {
        $posts = Post::with('category', 'user', 'comments', 'tags')->latest()->paginate(6);
        return response()->json([
            'success' => true,
            'posts' => $posts
        ], 200);
    }

    public function show(Request $request)
    {
        $post = Post::with([
            'category',
            'user',
            'comments' =>function($q){
                $q->orderByDesc('id');
            },
            'comments.user',
            'tags'
        ])->where('slug', $request->slug)->first();

        $prev = Post::where('id', '<', $post->id)->orderByDesc('id')->first();
        $next = Post::where('id', '>', $post->id)->orderBy('id')->first();
        return response()->json([
            'success' => true,
            'post' => $post,
            'next' => $next,
            'prev' =>  $prev,
        ], 200);
    }
}
