<?php

namespace CardzApp\Api\Account\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Account\Presentation\Transformers\UserTransformer;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class GetAuthUserController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private UserTransformer $userTransformer
    )
    {
    }

    public function __invoke(Request $request)
    {
        $user = $this->user();

        return $this->successResponse(
            $this->userTransformer->private($user)
        );
    }
}
