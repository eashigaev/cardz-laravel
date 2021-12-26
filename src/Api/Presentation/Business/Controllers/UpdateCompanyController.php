<?php

namespace CardzApp\Api\Presentation\Business\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Presentation\ControllerTrait;
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
        $attrs = [
            'title' => $request->title,
            'description' => $request->description,
            'about' => $request->about
        ];

        $company = $this->user()->companies()->findOrFail($request->company);

        $company->fill($attrs)->save();

        return $this->successResponse([
            'id' => $company->id
        ]);
    }
}
