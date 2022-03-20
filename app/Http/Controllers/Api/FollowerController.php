<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\MainController;
use App\Http\Requests\FollowingRequest;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends MainController
{
    public function follow(FollowingRequest $request){
        $user = User::where('username', $request->username)->first();
        if(!$user){
            return $this->error('Validation error', ['username' => 'is not found'], self::VALIDATION_ERROR);
        }
        if($user->id==$this->user->id){
            return $this->error('You can not follow yourself');
        }

        $this->user->following()->attach($user->id);

        return $this->response(['following_count' => $this->user->following()->count()], 'Followed successfully');
    }

    public function unfollow(FollowingRequest $request){
        $user = User::where('username', $request->username)->first();
        if(!$user){
            return $this->error('Validation error', ['username' => 'is not found'], self::VALIDATION_ERROR);
        }
        if($user->id==$this->user->id){
            return $this->error('You can not unfollow yourself');
        }

        $this->user->following()->detach($user->id);

        return $this->response(['following_count' => $this->user->following()->count()], 'Unfollowed successfully');

    }
}
