<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\MainController;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Validator;

class AuthController extends MainController
{
    public function users(){
        if($this->user->role!='admin'){
            return $this->error('You do not have permissions', [], self::FORBIDDEN);
        }

        $users = User::paginate(15);
        return $this->response(['users' => $users]);
    }

    public function search(Request $request){
        $q = ' ';
        if($request->has('q'))
            $q = $request->q;

        $users = User::orWhere('name', $q)->orWhere('username', $q)->get();
        return $this->response(['users' => $users]);
    }

    public function register(UserRegisterRequest $request){
        $user = User::create($request->validated());
        $token = $user->createToken('auth_token');

        return $this->response([
            'token'     =>  $token->plainTextToken,
            'user'      =>  $user
        ], 'Registered successfully');
    }

    public function login(UserLoginRequest $request){
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return $this->error('User is not found', [], self::NOT_FOUND);
        }

        if(! Hash::check($request->password, $user->password)){
            return ['error' => 'Password is wrong'];
        }
        $token = $user->createToken('auth_token');
        return $this->response([
            'token'     =>  $token->plainTextToken,
            'user'      =>  $user
        ], 'Logged in successfully');
    }

    public function loginToken(Request $request){
        $validator = Validator::make($request->all(), [
            'token'    =>  'required',
        ]);

        if($validator->fails()){
            $this->error('Validation error', ['token' => 'Token is wrong'], self::VALIDATION_ERROR);
        }

        $personalAccessToken = PersonalAccessToken::findToken($request->token);
        if(!$personalAccessToken) {
            $this->error('Token not found', [], self::NOT_FOUND);
        }

        return $this->response(['user' => $personalAccessToken->tokenable], 'Logged in successfully');
    }

    public function logout(Request $request){
        $this->user->tokens()->where('id', $this->user->currentAccessToken()->id)->delete();
        return $this->response([], 'Logged out successfully');
    }
}
