<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Intervention\Image\Facades\Image;
use App\Models as Models;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    //
    public function index($username)
    {


        // Retrieve the user from the database based on the username
        $user = User::where('username', $username)->first();
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
        $postCount = Cache::remember(
            'count.posts' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->posts->count();
            }

        );






        // $user = User::findOrFail(1);


        // Check if the user exists
        if (!$user) {
            // Handle the case where the user does not exist, maybe redirect to an error page
            abort(404, 'User not found');
        }

        // Pass the user data to the view
        return view('profiles.index', compact('user', 'follows', 'postCount'));
    }
    public function edit($username)
    {

        $user = User::where('username', $username)->first();
        $this->authorize('update', $user->profile);

        return view('profiles.edit', ['user' => $user]);

    }

    public function update($username)
    {
        // Fetch the user by username
        $user = Models\User::where('username', $username)->firstOrFail();

        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        if (request('image')) {
            $imagePath = request('image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $imageArray = ['image' => $imagePath];
        }

        auth()->user()->profile->update(
            array_merge(
                $data,
                $imageArray ?? []
            )
        );

        return redirect("/profile/{$user->username}");

    }


}
