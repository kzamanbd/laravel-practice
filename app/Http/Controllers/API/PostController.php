<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function posts()
    {
        $posts = Post::with([
            'category:id,name,slug',
            'user:id,name,username,created_at',
            'tags:id,name,slug,description',
            'comments:id,post_id,user_id,comment'
        ])->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'posts' => $posts
        ], 200);
    }

    public function show(string $slug)
    {
        $post = Post::with([
            'category:id,name,slug',
            'user:id,name,username,created_at',
            'tags:id,name,slug,description',
            'comments' => function ($q) {
                $q->orderByDesc('id');
            },
            'comments.user'
        ])->where('slug', $slug)->firstOrFail();

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
