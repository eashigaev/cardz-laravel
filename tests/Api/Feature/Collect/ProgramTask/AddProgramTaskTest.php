<?php

namespace Tests\Api\Feature\Collect\Program;

use App\Models\Collect\ProgramTask;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use Tests\Api\Support\ModuleTestTrait;
use Tests\TestCase;

class AddProgramTaskTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_ADD_PROGRAM_TASK;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_ADD_PROGRAM_TASK);
    }

    public function test_action()
    {
        $fixture = ProgramTask::factory()->make();
        $user = $fixture->company->founder;

        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, [
            'title' => $fixture->title,
            'description' => $fixture->description,
        ], [
            'program' => $fixture->program->id
        ]);
        $response->assertStatus(200);

        $result = ProgramTask::query()->findOrFail($response['id']);
        $this->assertArraySubset([
            'company_id' => $fixture->company->id,
            'program_id' => $fixture->program->id,
            'title' => $fixture->title,
            'description' => $fixture->description,
            'available' => false,
            'repeatable' => false
        ], $result->toArray());
    }
}
