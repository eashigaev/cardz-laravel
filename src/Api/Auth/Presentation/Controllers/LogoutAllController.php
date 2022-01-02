<?php

namespace CardzApp\Api\Auth\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Auth\Application\Services\TokenService;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class LogoutAllController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private TokenService $tokenService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $this->tokenService->logoutAll($request->user());

        return $this->successResponse();
    }
}
