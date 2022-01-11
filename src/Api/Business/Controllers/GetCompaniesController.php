<?php

namespace CardzApp\Api\Business\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Business\Transformers\CompanyTransformer;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Business\Application\Services\CompanyService;
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
            ->map(fn($i) => $this->companyTransformer->preview($i));

        return $this->successResponse($companies);
    }
}
