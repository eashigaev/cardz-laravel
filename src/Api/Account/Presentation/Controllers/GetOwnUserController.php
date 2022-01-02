<?php

namespace CardzApp\Api\Account\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Account\Application\Services\UserService;
use CardzApp\Api\Account\Presentation\Transformers\UserTransformer;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class GetOwnUserController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private UserService     $userService,
        private UserTransformer $userTransformer,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $user = $this->userService->getUser(
            $request->user()->id
        );

        return $this->successResponse(
            $this->userTransformer->private($user)
        );
    }
}
