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
        $this->user()->fill($request->all())->save();

        return $this->successResponse();
    }
}
