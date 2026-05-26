<?php

namespace   App\Http\Controllers\Api\V1;

use App\ApiResponseTrait;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\LoginRequest;
use App\Services\V1\UserService;
use Illuminate\Http\Request;

class AuthController{

 use ApiResponseTrait;
    public function __construct(protected UserService $userService)
    {

    }

      public function register(CreateUserRequest $user){

    $data=$this->userService->register($user);

     return $this->successResponse(
           $data,
            'User registered successfully 😊💛'
        );
    }

    public function login(LoginRequest   $request){

        $data=$this->userService->login($request);

         return $this->successResponse(
               $data,
                'User logged in successfully 😊💛'
            );
    }

    public function logout(Request $request){

        $data=$this->userService->logout($request);

         return $this->successResponse(
               $data,
                'User logged out successfully 😊💛'
            );
    }
}
