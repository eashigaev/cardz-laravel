<?php

namespace CardzApp\Api\Tests\Feature\Business;

use App\Models\Company;
use CardzApp\Api\Shared\Presentation\Routes;
use CardzApp\Api\Tests\Support\ModuleTestTrait;
use Tests\TestCase;

class GetCompanyTest extends TestCase
{
    private const ROUTE = Routes::BUSINESS_GET_COMPANY;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        //$user = User::factory()->has(Company::factory()->count(3))->create();

        $company = Company::factory()->create();
        $this->actingAsSanctum($company->founder);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'company' => $company->id
        ]);
        $response->assertStatus(200);

        $response->assertJson([
            'id' => $company->id,
            'title' => $company->title,
            'description' => $company->description,
            'about' => $company->about
        ]);
    }
}
