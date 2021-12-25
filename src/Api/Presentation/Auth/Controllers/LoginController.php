<?php

namespace CardzApp\Api\Presentation\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use CardzApp\Api\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ControllerTrait;

    public function __invoke(Request $request)
    {
        $user = User::findByCredentialsOrFail(
            $request->username, $request->password
        );

        $tokenName = $request->tokenName ?? 'API_TOKEN';
        $token = $user->createToken($tokenName)->plainTextToken;

        return $this->successResponse([
            'token' => $token
        ]);
    }
}
