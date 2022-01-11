<?php

namespace CardzApp\Api\Account\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Account\Transformers\UserTransformer;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Account\Application\Services\UserService;
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
