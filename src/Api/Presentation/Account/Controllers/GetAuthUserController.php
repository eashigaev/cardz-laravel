<?php

namespace CardzApp\Api\Presentation\Account\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Presentation\Account\Transformers\UserTransformer;
use CardzApp\Api\Presentation\ControllerTrait;
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
