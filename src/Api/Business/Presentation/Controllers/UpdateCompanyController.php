<?php

namespace CardzApp\Api\Business\Presentation\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Business\Application\Services\CompanyService;
use CardzApp\Api\Business\Domain\CompanyProfile;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Illuminate\Http\Request;

class UpdateCompanyController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private CompanyService $companyService
    )
    {
    }

    public function __invoke(Request $request)
    {
        $profile = CompanyProfile::of(
            $request->title,
            $request->description,
            $request->summary
        );

        $this->companyService->updateCompany(
            $request->user()->id, $request->company, $profile
        );

        return $this->successResponse();
    }
}
