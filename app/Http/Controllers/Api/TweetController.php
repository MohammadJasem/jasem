<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\MainController;
use App\Http\Requests\TweetOnBehalfRequest;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\TweetRequest;

class TweetController extends MainController
{
    public function index(Request $request){
        if($this->user->role=='admin'){
            if($request->has('username')) {
                if(!$user = User::where('username', $request->username)->first()){
                    return $this->error('User is not found', [], self::NOT_FOUND);
                }
                $tweets = $user->tweets()->paginate(15);
            } else {
                $tweets = Tweet::paginate(15);
            }
        } else {
            $tweets = $this->user->tweets->paginate(15);
        }

        return $this->response(['tweets' => $tweets]);
    }

    public function feeds(){
        $followingUsers = $this->user->following;
        $feeds = [];
        foreach ($followingUsers as $followingUser){
            array_push($feeds, array_values($followingUser->tweets->toArray()));
        }

        return $this->response(['feeds' => $feeds]);
    }

    public function store(TweetRequest $request){
        $data = $request->validated();
        $data['user_id'] = $this->user->id;
        $tweet = Tweet::create($data);

        return $this->response(['tweet' => $tweet], 'Tweet created successfully');
    }

    public function tweetOnBehalf(TweetOnBehalfRequest $request){
        if($this->user->role!='admin')
            return $this->error('You do not have permissions to tweet on be half this user');

        $tweet = Tweet::create($request->validated());
        return $this->response(['tweet' => $tweet], 'Tweet on behalf has been created successfully');
    }

    public function show(Tweet $tweet){
        return $this->response(['tweet' => $tweet]);
    }

    public function update(TweetRequest $request, Tweet $tweet){
        $tweet->update($request->validated());

        return $this->response(['tweet' => $tweet], 'Tweet updated successfully');
    }

    public function destroy(Tweet $tweet){
        if($tweet->delete()){
            return $this->response([], 'Tweet deleted successfully');
        }

        return $this->error('something went wrong, please try again');
    }
}
