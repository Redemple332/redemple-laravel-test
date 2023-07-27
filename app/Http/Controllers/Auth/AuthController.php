<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\SubscribeRequest;
use App\Http\Resources\UserResource;
use App\Services\Authentication\AuthService;
use App\Services\Utils\ResponseServiceInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $authService;
    private $responseService;

    public function __construct(AuthService $authService, ResponseServiceInterface $responseService){
        $this->authService = $authService;
        $this->responseService = $responseService;
    }

   public function login(LoginRequest $request) {
        $data = $this->authService->login($request->validated());
        $cookie = cookie('token', $data['token'], 3600);
        return $this->responseService->authResponse("Login Successful", $data, $cookie);
    }

    public function logout() {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return $this->responseService->resolveResponse("Logout Successful", null);
    }

    public function register(){

    }
    public function authUser(){
        $user =  new UserResource(Auth::user());
        return $this->responseService->resolveResponse("Auth User", $user);
    }

    public function subscribe() {
        $user = Auth::user();
        $user->update(
            [
                'is_subscribe' => $user->is_subscribe == 1? 0 : 1
            ]
        );
        return $this->responseService->resolveResponse("Subscribe Status Change Successfully!", $user);
    }


}
