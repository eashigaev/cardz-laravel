<?php

namespace CardzApp\Api\Auth\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Account\Application\Services\UserService;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private UserService $userService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $user = $this->userService->getUserByCredentials(
            $request->username, $request->password
        );

        $tokenName = $request->tokenName ?? 'API_TOKEN';
        $token = $user->createToken($tokenName)->plainTextToken;

        return $this->successResponse([
            'token' => $token
        ]);
    }
}
