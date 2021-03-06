<?php

namespace CardzApp\Modules\Auth\Application\Services;

use CardzApp\Modules\Account\Application\Services\UserService;
use CardzApp\Modules\Account\Domain\UserCredentials;
use Illuminate\Contracts\Auth\Authenticatable;

class TokenService
{
    public function __construct(
        private UserService $userService
    )
    {
    }

    public function login(UserCredentials $credentials, string $tokenName)
    {
        $user = $this->userService->getUserByCredentials($credentials);

        return $user->createToken($tokenName)->plainTextToken;
    }

    public function logout(Authenticatable $user)
    {
        $user->currentAccessToken()->delete();
    }

    public function logoutAll(Authenticatable $user)
    {
        $user->tokens()->delete();
    }
}
