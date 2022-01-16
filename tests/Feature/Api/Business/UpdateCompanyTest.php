<?php

namespace Tests\Feature\Api\Business;

use App\Models\Company;
use CardzApp\Api\Shared\Routes;
use Tests\Feature\Api\FeatureTestTrait;
use Tests\TestCase;

class UpdateCompanyTest extends TestCase
{
    private const ROUTE = Routes::BUSINESS_UPDATE_COMPANY;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        $fixture = Company::factory()->make();
        $company = Company::factory()->create();

        $this->actingAsCompany($company);

        $response = $this->callJsonRoute(self::ROUTE, [
            'title' => $fixture->title,
            'description' => $fixture->description,
            'summary' => $fixture->summary
        ], [
            'company' => $company->id
        ]);
        $response->assertStatus(200);

        $result = Company::query()->findOrFail($company->id);
        $this->assertArraySubset([
            'title' => $fixture->title,
            'description' => $fixture->description,
            'summary' => $fixture->summary
        ], $result->toArray());
    }
}
