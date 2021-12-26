<?php

namespace CardzApp\Api\Presentation\Account\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class UpdateAuthUserController extends Controller
{
    use ControllerTrait;

    public function __invoke(Request $request)
    {
        $attrs = [
            'username' => $request->username,
            'password' => $request->password
        ];

        $this->user()->fill($attrs)->save();

        return $this->successResponse();
    }
}
