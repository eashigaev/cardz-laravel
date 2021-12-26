<?php

namespace CardzApp\Api\Tests\Feature\Business;

use App\Models\Company;
use App\Models\User;
use CardzApp\Api\Presentation\Routes;
use CardzApp\Api\Tests\Support\ModuleTestTrait;
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
        $user = User::factory()->has(Company::factory()->count(3))->create();
        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE);
        $response->assertStatus(200);

        foreach ($user->companies as $company) {
            $response->assertJsonFragment([
                'id' => $company->id,
                'title' => $company->title,
                'description' => $company->description,
            ]);
            $this->assertArrayNotHasKeys([
                'about'
            ], $response->json());
        }
    }
}
