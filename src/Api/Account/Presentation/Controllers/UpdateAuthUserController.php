<?php

namespace CardzApp\Api\Account\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class UpdateAuthUserController extends Controller
{
    use ControllerTrait;

    public function __invoke(Request $request)
    {
        $attrs = $request->only(['username', 'password']);

        $this->user()->fill($attrs)->save();

        return $this->successResponse();
    }
}
