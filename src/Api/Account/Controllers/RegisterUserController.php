<?php

namespace CardzApp\Api\Account\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Account\Application\Services\UserService;
use CardzApp\Modules\Account\Domain\UserCredentials;
use CardzApp\Modules\Account\Domain\UserProfile;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private UserService $userService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $credentials = UserCredentials::of(
            $request->username,
            $request->password
        );
        $profile = UserProfile::of(
            $request->email
        );

        $userId = $this->userService->registerUser(
            $credentials, $profile
        );

        return $this->successResponse([
            'id' => $userId
        ]);
    }
}
