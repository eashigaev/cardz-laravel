<?php

namespace Tests\Api\Feature\Business;

use App\Models\Company;
use App\Models\User;
use CardzApp\Api\Shared\Routes;
use Tests\Api\Feature\FeatureTestTrait;
use Tests\TestCase;

class GetCompaniesTest extends TestCase
{
    private const ROUTE = Routes::BUSINESS_GET_COMPANIES;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        $companies = Company::factory()->for(User::factory(), 'founder')->count(3)->create();

        $this->actingAsCompany($companies->first());

        $response = $this->callJsonRoute(self::ROUTE);
        $response->assertStatus(200);

        foreach ($companies as $company) {
            $response->assertJsonFragment([
                'id' => $company->id,
                'title' => $company->title,
                'description' => $company->description,
            ]);
            $this->assertArrayNotHasKeys([
                'summary'
            ], $response->json());
        }
    }
}
