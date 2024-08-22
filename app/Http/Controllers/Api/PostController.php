<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function posts()
    {
        $posts = Post::with([
            'category:id,name,slug',
            'user:id,name,created_at',
            'tags:id,name,slug,description',
            'comments:id,post_id,user_id,comment',
        ])
            ->select(['id', 'title', 'slug', 'image', 'category_id', 'user_id', 'created_at'])
            ->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'posts' => $posts,
        ], 200);
    }

    public function show(string $slug)
    {
        $post = Post::with([
            'category:id,name,slug',
            'user:id,name,created_at',
            'tags:id,name,slug,description',
            'comments' => function ($q) {
                $q->orderByDesc('id');
                $q->select(['id', 'post_id', 'user_id', 'comment']);
            },
            'comments.user:id,name,created_at',
        ])->where('slug', $slug)->firstOrFail();

        $prev = Post::where('id', '<', $post->id)
            ->orderByDesc('id')->first(['id', 'title', 'slug', 'image']);

        $next = Post::where('id', '>', $post->id)
            ->orderBy('id')->first(['id', 'title', 'slug', 'image']);

        return response()->json([
            'success' => true,
            'post' => $post,
            'next' => $next,
            'prev' => $prev,
        ], 200);
    }
}
