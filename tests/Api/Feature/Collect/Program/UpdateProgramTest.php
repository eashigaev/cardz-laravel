<?php

namespace Tests\Api\Feature\Collect\Program;

use App\Models\Collect\Program;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use Tests\Api\Support\ModuleTestTrait;
use Tests\TestCase;

class UpdateProgramTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_UPDATE_PROGRAM;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_UPDATE_PROGRAM);
    }

    public function test_action()
    {
        $fixture = Program::factory()->make();
        $program = Program::factory()->create();
        $user = $program->company->founder;

        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, [
            'title' => $fixture->title,
            'description' => $fixture->description,
            'reward_title' => $fixture->reward_title,
            'reward_target' => $fixture->reward_target
        ], [
            'program' => $program->id
        ]);
        $response->assertStatus(200);

        $result = Program::query()->findOrFail($program->id);
        $this->assertArraySubset([
            'title' => $fixture->title,
            'description' => $fixture->description,
            'reward_title' => $fixture->reward_title,
            'reward_target' => $fixture->reward_target
        ], $result->toArray());
    }
}
