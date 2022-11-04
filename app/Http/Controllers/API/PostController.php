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
        $posts = Post::with([
            'category:id,name,slug',
            'user:id,name,username,email,profile_photo_path,created_at',
            'tags:id,name,slug,description',
            'comments:id,post_id,user_id,comment'
        ])->latest()->paginate(6);
        return response()->json([
            'success' => true,
            'posts' => $posts
        ], 200);
    }

    public function show(Request $request)
    {
        $post = Post::with([
            'category:id,name,slug',
            'user:id,name,username,email,profile_photo_path,created_at',
            'tags:id,name,slug,description',
            'comments' => function ($q) {
                $q->orderByDesc('id');
            },
            'comments.user'
        ])->where('slug', $request->slug)->firstOrFail();

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
