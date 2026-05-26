<?php

namespace App\Services\V1;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use App\Action\V1\User\CreateUserAction;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function register(CreateUserRequest $request)
    {
        $data=$request->validated();

        $user=CreateUserAction::execute($data);

        $token=$user->createToken('auth_token')->plainTextToken;


        SendWelcomeEmailJob::dispatch($user);
        return [
            'user'=>$user,
            'token'=>$token,
        ];
    }
  public function login(LoginRequest $request){

  $user=User::where('email',$request->email)->first();

 if(!$user || !Hash::check($request->password,$user->password)){

  return [
    'message' => 'Invalid credentials'
];

}
$token=$user->createToken('login_token')->plainTextToken;

    return [

        'data'=>[
        'user' => $user,
        'token' => $user->createToken('login_token')->plainTextToken,
        'role'=>$user->role]
    ];

}

public function logout(HttpRequest $request){

$request->user()->currentAccessToken()->delete();

   return [

            'message' => 'Logged out successfully'
        ];
}


}
