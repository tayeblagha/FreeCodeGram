<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/home', function () {
//     return view('welcome');
// });
Auth::routes();

Route::get('/profile/{username}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile.show');
Route::get('/profile/{username}/edit', [App\Http\Controllers\ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{username}', [App\Http\Controllers\ProfilesController::class, 'update'])->name('profile.update');
;

// add new post Route
Route::get('/post/create', [App\Http\Controllers\PostsController::class, 'create']);
// ->name('post.create');

Route::post('/post', [App\Http\Controllers\PostsController::class, 'store']);

Route::get('/post/{post}', [App\Http\Controllers\PostsController::class, 'show']);

Route::get('/followingposts', [App\Http\Controllers\PostsController::class, 'posts']);




//follow Button 
Route::post('/follow/{username}', [App\Http\Controllers\FollowsController::class, 'store']);


