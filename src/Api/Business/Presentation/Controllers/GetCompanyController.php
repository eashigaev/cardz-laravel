<?php

namespace CardzApp\Api\Business\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Business\Presentation\Transformers\CompanyTransformer;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Illuminate\Http\Request;

class GetCompanyController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private UuidGenerator      $uuidGenerator,
        private CompanyTransformer $companyTransformer
    )
    {
    }

    public function __invoke(Request $request)
    {
        $company = $this->user()->companies()->findOrFail($request->company);

        return $this->successResponse(
            $this->companyTransformer->detail($company)
        );
    }
}
