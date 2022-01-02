<?php

namespace CardzApp\Api\Account\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Account\Application\Services\UserService;
use CardzApp\Api\Account\Domain\UserCredentials;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
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

        $this->userService->updateOwnUser(
            $request->user()->id, $credentials
        );

        return $this->successResponse();
    }
}
