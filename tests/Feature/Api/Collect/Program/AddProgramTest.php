<?php

namespace Tests\Feature\Api\Collect\Program;

use App\Models\Collect\Program;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Feature\Api\FeatureTestTrait;
use Tests\TestCase;

class AddProgramTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_ADD_PROGRAM;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_ADD_PROGRAM);
    }

    public function test_action()
    {
        $fixture = Program::factory()->make();

        $this->actingAsCompany($fixture->company);

        $response = $this->callJsonRoute(self::ROUTE, [
            'title' => $fixture->title,
            'description' => $fixture->description,
            'reward_title' => $fixture->reward_title,
            'reward_target' => $fixture->reward_target
        ], [
            'company' => $fixture->company->id
        ]);
        $response->assertStatus(200);

        $result = Program::query()->findOrFail($response['id']);
        $this->assertArraySubset([
            'company_id' => $fixture->company->id,
            'title' => $fixture->title,
            'description' => $fixture->description,
            'reward_title' => $fixture->reward_title,
            'reward_target' => $fixture->reward_target,
            'active' => false
        ], $result->toArray());
    }
}
