<?php

namespace CardzApp\Api\Business\Presentation\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
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
        $attrs = $request->only(['title', 'description', 'about']);

        $company = new Company($attrs);
        $company->id = $this->uuidGenerator->getNextValue();
        $this->user()->companies()->save($company);

        return $this->successResponse([
            'id' => $company->id
        ]);
    }
}
