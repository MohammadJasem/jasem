<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\MainController;
use App\Http\Requests\RetweetingRequest;
use App\Models\Tweet;
use Illuminate\Http\Request;

class RetweetController extends MainController
{
    public function retweet(RetweetingRequest $request){
        $tweet = Tweet::find($request->tweet_id);
        if(!$tweet){
            return $this->error('Validation error', ['tweet' => 'is not found'], self::VALIDATION_ERROR);
        }
        if($tweet->user_id==$this->user->id){
            return $this->error('You can not retweet your own tweet');
        }

        $this->user->retweets()->attach($tweet->id);

        return $this->response([], 'Retweeted successfully');
    }

    public function removeRetweet(RetweetingRequest $request){
        $tweet = Tweet::find($request->tweet_id);
        if(!$tweet){
            return $this->error('Validation error', ['tweet' => 'is not found'], self::VALIDATION_ERROR);
        }

        $this->user->retweets()->detach($tweet->id);

        return $this->response([], 'Retweet removed successfully');
    }
}
