<?php

namespace CardzApp\Api\Business\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Illuminate\Http\Request;

class UpdateCompanyController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private UuidGenerator $uuidGenerator
    )
    {
    }

    public function __invoke(Request $request)
    {
        $attrs = $request->only(['title', 'description', 'about']);

        $company = $this->user()->companies()->findOrFail($request->company);

        $company->fill($attrs)->save();

        return $this->successResponse();
    }
}
