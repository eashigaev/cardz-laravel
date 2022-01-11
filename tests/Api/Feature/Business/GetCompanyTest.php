<?php

namespace Tests\Api\Feature\Business;

use App\Models\Company;
use CardzApp\Api\Shared\Routes;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class GetCompanyTest extends TestCase
{
    private const ROUTE = Routes::BUSINESS_GET_COMPANY;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        $company = Company::factory()->create();

        $user = $company->founder;
        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'company' => $company->id
        ]);
        $response->assertStatus(200);

        $response->assertJson([
            'id' => $company->id,
            'title' => $company->title,
            'description' => $company->description,
            'summary' => $company->summary
        ]);
    }
}
