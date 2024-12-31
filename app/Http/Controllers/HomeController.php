<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->take(4)->get();
        $posts->transform(function ($post) {
            $post->featured_image = asset('storage/' . $post->featured_image);
            return $post;
        });
        return Inertia::render('Home', [
            'posts' => $posts
        ]);
    }

    public function blog()
    {
        $posts = Post::latest()->get();
        $posts->transform(function ($post) {
            $post->featured_image = asset('storage/' . $post->featured_image);
            return $post;
        });
        return Inertia::render('Blog', [
            'posts' => $posts
        ]);
    }
}
