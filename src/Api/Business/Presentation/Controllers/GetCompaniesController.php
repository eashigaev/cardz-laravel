<?php

namespace CardzApp\Api\Business\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Business\Application\Services\CompanyService;
use CardzApp\Api\Business\Presentation\Transformers\CompanyTransformer;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class GetCompaniesController extends Controller
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
        $companies = $this->companyService
            ->getCompanies($request->user()->id)
            ->map(fn($u) => $this->companyTransformer->preview($u));

        return $this->successResponse($companies);
    }
}
