<?php

namespace CardzApp\Api\Tests\Feature\Business;

use App\Models\Company;
use CardzApp\Api\Presentation\Routes;
use CardzApp\Api\Tests\Support\ModuleTestTrait;
use Tests\TestCase;

class UpdateCompanyTest extends TestCase
{
    private const ROUTE = Routes::BUSINESS_UPDATE_COMPANY;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        $fixture = Company::factory()->make();
        $company = Company::factory()->create();
        $this->actingAsSanctum($company->founder);

        $response = $this->callJsonRoute(self::ROUTE, [
            'title' => $fixture->title,
            'description' => $fixture->description,
            'about' => $fixture->about
        ], [
            'company' => $company->id
        ]);
        $response->assertStatus(200);

        $result = Company::query()->findOrFail($company->id);
        $this->assertArraySubset([
            'title' => $fixture->title,
            'description' => $fixture->description,
            'about' => $fixture->about
        ], $result->toArray());
    }
}
