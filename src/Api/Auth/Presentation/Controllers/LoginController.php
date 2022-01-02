<?php

namespace CardzApp\Api\Auth\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Account\Domain\UserCredentials;
use CardzApp\Api\Auth\Application\Services\TokenService;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private TokenService $tokenService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $credentials = UserCredentials::of(
            $request->username, $request->password
        );

        $token = $this->tokenService->login(
            $credentials, $request->tokenName ?? 'API_TOKEN'
        );

        return $this->successResponse([
            'token' => $token
        ]);
    }


}
