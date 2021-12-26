<?php

namespace CardzApp\Api\Presentation\Business\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use CardzApp\Api\Presentation\ControllerTrait;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Illuminate\Http\Request;

class FoundCompanyController extends Controller
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

        $company = new Company($attrs);
        $company->id = $this->uuidGenerator->getNextValue();
        $this->user()->companies()->save($company);

        return $this->successResponse([
            'id' => $company->id
        ]);
    }
}
