<?php

namespace CardzApp\Api\Business\Application\Services;

use App\Http\Controllers\Controller;
use App\Models\Company;
use CardzApp\Api\Business\Domain\CompanyProfile;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;

class CompanyService extends Controller
{
    public function __construct(
        private UuidGenerator $uuidGenerator
    )
    {
    }

    public function foundCompany(string $founderId, CompanyProfile $profile)
    {
        $company = Company::query()->make($profile->toArray());
        $company->id = $this->uuidGenerator->getNextValue();
        $company->founder()->associate($founderId);
        $company->save();

        return $company->id;
    }

    public function updateCompany(string $founderId, string $companyId, CompanyProfile $profile)
    {
        return Company::query()
            ->ofFounder($founderId)
            ->findOrFail($companyId)
            ->fill($profile->toArray())
            ->save();
    }

    //

    public function getCompany(string $founderId, string $companyId)
    {
        return Company::query()
            ->ofFounder($founderId)
            ->findOrFail($companyId);
    }

    public function getCompanies(string $founderId)
    {
        return Company::query()
            ->ofFounder($founderId)
            ->get();
    }
}