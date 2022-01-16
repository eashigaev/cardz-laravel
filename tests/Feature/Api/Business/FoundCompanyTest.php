<?php

namespace Tests\Feature\Api\Business;

use App\Models\Company;
use App\Models\User;
use CardzApp\Api\Shared\Routes;
use Tests\Feature\Api\FeatureTestTrait;
use Tests\TestCase;

class FoundCompanyTest extends TestCase
{
    private const ROUTE = Routes::BUSINESS_FOUND_COMPANY;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        $user = User::factory()->create();

        $this->actingAsSanctum($user);

        $fixture = Company::factory()->make();

        $response = $this->callJsonRoute(self::ROUTE, [
            'title' => $fixture->title,
            'description' => $fixture->description,
            'summary' => $fixture->summary
        ]);
        $response->assertStatus(200);

        $result = Company::query()->findOrFail($response['id']);
        $this->assertArraySubset([
            'title' => $fixture->title,
            'description' => $fixture->description,
            'summary' => $fixture->summary
        ], $result->toArray());
    }
}
