@extends('layouts.app')

@section('content')


<link href="/css/app.css" rel="stylesheet">
<script src="/js/profile.js"></script>


<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="{{ $user->profile->profileImage() }}" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-3">
                    <div class="h4">{{ $user->username }}</div>
                    @can('view',$user->profile)

                    <button class="btn ml-4 {{ $follows == false ? 'btn-primary' : 'btn-secondary' }}" id="followButton"
                        onclick="followUser('{{ $user->username }}')"
                        value="{{ $follows == true ? 'Unfollow' : 'Follow' }}">
                        {{ $follows == true ? 'Unfollow' : 'Follow' }}
                    </button>
                    @endcan



                </div>

                @can('update', $user->profile)
                <a href="/post/create">Add New Post</a>
                @endcan

            </div>





            @can('update',$user->profile)

            <a href="/profile/{{$user->username}}/edit" style="margin-left: auto;"> Edit Profile</a>
            @endcan
            <div class="d-flex">

                <div class="pe-3"><strong>{{$postCount }}</strong> Posts</div>
                <div class="pe-3"><strong> {{$user->profile->followers->count() ?? 'N/A'}}</strong> followers</div>
                <div class="pe-3"><strong>{{$user->following->count() ?? 'N/A'}}</strong> following</div>
            </div>
            <div class="pt-4 font-weight-bold">{{ $user->profile->title ?? '' }} </div>
            <div>
                {{ $user->profile->description ?? ''}}

            </div>
            <div><a href="#">
                    {{ $user->profile->url ?? "freecodeccamp.org" }} </a></div>
        </div>
    </div>


    <div class="row pt-5">
        @foreach($user->posts as $post)
        <div class="col-4 pb-4">
            <a href="/post/{{ $post->id }}">
                <img src="/storage/{{ $post->image }}" class="w-100">
            </a>
        </div>
        @endforeach
    </div>

    <!-- <div class="col-4">
            <img class="w-100 p-1 h-50" src="/Images/freecodeCamp2.png">
        </div>
        <div class="col-4">
            <img class="w-100 p-1 h-50" src="/Images/freecodeCamp3.png">
        </div> -->
</div>

</div>
</div>

@endsection