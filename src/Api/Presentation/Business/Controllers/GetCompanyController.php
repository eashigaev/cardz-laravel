<?php

namespace CardzApp\Api\Presentation\Business\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Presentation\Business\Transformers\CompanyTransformer;
use CardzApp\Api\Presentation\ControllerTrait;
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
