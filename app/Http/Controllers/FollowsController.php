<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FollowsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store($username)
    {


        $user = User::where('username', $username)->first();
        // $user = new User();
        // $user->username = $username;
        return auth()->user()->following()->toggle($user->profile);        //return $user->profile()->followers();

    }


    //
}
