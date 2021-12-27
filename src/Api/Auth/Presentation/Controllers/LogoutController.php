<?php

namespace CardzApp\Api\Auth\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use ControllerTrait;

    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse();
    }
}
