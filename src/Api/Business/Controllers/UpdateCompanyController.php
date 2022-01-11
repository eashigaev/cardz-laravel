<?php

namespace CardzApp\Api\Business\Controllers;

use App\Http\Controllers\Controller;
use CardzApp\Api\Shared\ControllerTrait;
use CardzApp\Modules\Business\Application\Services\CompanyService;
use CardzApp\Modules\Business\Domain\CompanyProfile;
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
