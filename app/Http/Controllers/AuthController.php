<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponse;
    public function login(LoginUserRequest $request){
        $request->validated($request->only(['email', 'password']));

        if(!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->sucess([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    // $request->validated($request->all());
    // if(!Auth::attempt($request->only(['email',"password"])))    {
    //     return $this->error('', 'Credentials do not match', 401);
    // }
    // $user =User::where("email",$request->email)->first();
    // return $this->sucess([
    //     "user"=>$user,
    //     "token"=>$user->createToken("API Token of".$user->name)->plainTextToken,
    //    ]);
    }
    public function register(StoreUserRequest $request){
       $request->validated
       ($request->all());
       $user = User::create([
        "name"=>$request->name,
        "email"=>$request->email,
        "password"=>Hash::make($request->password),

       ]);
       return $this->sucess([
        "user"=>$user,
        "token"=>$user->createToken("API Token of".$user->name)->plainTextToken,

       ]);
    }
    public function logOut(){
        Auth::user()->currentAccessToken()->delete();

        return $this->sucess([
            'message' => 'You have succesfully been logged out and your token has been removed'
        ]);
    }
    

}
