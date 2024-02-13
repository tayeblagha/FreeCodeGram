<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models as Models;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'another' => '', // I assume you are validating other fields here
            'image' => ['required', 'image'],
            'caption' => 'required',
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(900, 900);

        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        $username = auth()->user()->username;
        return redirect("/profile/{$username}");
    }
    public function show(Models\Post $post)
    {
        // $post = auth()->user()->posts()->find($post_id);
        //dd($post->user);

        // return view('posts.show', ['post' => $post]);

        return view('posts.show', compact('post'));
    }

    public function posts()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Models\Post::whereIn('user_id', $users)->with('user')->latest()->paginate(2);

        return view('posts.followingposts', compact('posts'));
    }


}
