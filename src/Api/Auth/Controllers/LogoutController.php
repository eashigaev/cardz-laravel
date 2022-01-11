<?php

namespace CardzApp\Api\Auth\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Auth\Application\Services\TokenService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private TokenService $tokenService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $this->tokenService->logout($request->user());

        return $this->successResponse();
    }
}
