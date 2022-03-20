<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TweetController;
use App\Http\Controllers\Api\FollowerController;
use App\Http\Controllers\Api\RetweetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('login-token', [AuthController::class, 'loginToken']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('users', [AuthController::class, 'users']);

    Route::resource('tweets', TweetController::class);
    Route::post('tweet-on-behalf', [TweetController::class, 'tweetOnBehalf']);

    Route::get('feeds', [TweetController::class, 'feeds']);

    Route::post('retweet', [RetweetController::class, 'retweet']);
    Route::delete('remove-retweet', [RetweetController::class, 'removeRetweet']);

    Route::post('follow', [FollowerController::class, 'follow']);
    Route::post('unfollow', [FollowerController::class, 'unfollow']);

    Route::get('search', [AuthController::class, 'search']);
});
