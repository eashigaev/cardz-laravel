<?php

namespace Tests\Api\Feature\Business;

use App\Models\Company;
use App\Models\User;
use CardzApp\Api\Shared\Presentation\Routes;
use Tests\Api\Support\ModuleTestTrait;
use Tests\TestCase;

class GetCompaniesTest extends TestCase
{
    private const ROUTE = Routes::BUSINESS_GET_COMPANIES;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        $companies = Company::factory()->for(User::factory(), 'founder')->count(3)->create();

        $user = $companies->first()->founder;
        $this->actingAsSanctum($user);

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
