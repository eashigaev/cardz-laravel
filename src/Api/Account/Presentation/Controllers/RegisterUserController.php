<?php

namespace CardzApp\Api\Account\Presentation\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private UuidGenerator $uuidGenerator
    )
    {
    }

    public function __invoke(Request $request)
    {
        $attrs = $request->only(['username', 'password', 'email']);

        $user = new User($attrs);
        $user->id = $this->uuidGenerator->getNextValue();
        $user->save();

        return $this->successResponse([
            'id' => $user->id
        ]);
    }
}
