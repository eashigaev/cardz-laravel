<?php

namespace CardzApp\Api\Business\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Business\Application\CompanyService;
use CardzApp\Api\Business\Presentation\Transformers\CompanyTransformer;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class GetCompanyController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private CompanyService     $companyService,
        private CompanyTransformer $companyTransformer
    )
    {
    }

    public function __invoke(Request $request)
    {
        $company = $this->companyService->getCompany(
            $request->user()->id, $request->company
        );

        return $this->successResponse(
            $this->companyTransformer->detail($company)
        );
    }
}
