<?php

namespace CardzApp\Api\Account\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Account\Application\Services\UserService;
use CardzApp\Modules\Account\Domain\UserCredentials;
use Illuminate\Http\Request;

class UpdateOwnUserController extends Controller
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

        $this->userService->updateUser(
            $request->user()->id, $credentials
        );

        return $this->successResponse();
    }
}
