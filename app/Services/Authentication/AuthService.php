<?php

namespace App\Services\Authentication;

use App\Repository\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthService implements AuthServiceInterface {

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $data)
    {
        $user = $this->userRepository->getUserByEmailUsername($data['email']);

        if (Auth::attempt(['username' => $data['email'], 'password' => $data['password']]) ||
            Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return [
                'token' => $user->createToken('token-name')->plainTextToken,
                'user' => $user
            ];
        } else {
            throw ValidationException::withMessages([
                'invalid_user_name_or_password' => "Invalid Username or Password"
            ]);
        }
    }
}
