<?php

namespace Tests\Api\Feature\Collect\Program;

use App\Models\Collect\Program;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Api\Feature\FeatureTestTrait;
use Tests\TestCase;

class GetProgramTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_GET_PROGRAM;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_GET_PROGRAM);
    }

    public function test_action()
    {
        $program = Program::factory()->create();

        $this->actingAsCompany($program->company);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'program' => $program->id
        ]);
        $response->assertStatus(200);

        $response->assertJson([
            'id' => $program->id,
            'company_id' => $program->company->id,
            'title' => $program->title,
            'description' => $program->description,
            'active' => $program->active,
            'reward' => [
                'title' => $program->reward_title,
                'target' => $program->reward_target
            ]
        ]);
    }
}
