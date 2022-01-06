<?php

namespace Tests\Api\Feature\Collect\ProgramTask;

use App\Models\Collect\Program;
use App\Models\Collect\ProgramTask;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use Tests\Api\Support\ModuleTestTrait;
use Tests\TestCase;

class GetProgramTasksTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_GET_PROGRAM_TASKS;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_GET_PROGRAM_TASKS);
    }

    public function test_action()
    {
        $program = Program::factory()->create();
        $tasks = ProgramTask::factory()->for($program)->count(3)->create();

        $this->actingAsSanctum($program->company->founder);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'program' => $program->id
        ]);
        $response->assertStatus(200);

        foreach ($tasks as $task) {
            $response->assertJsonFragment([
                'id' => $task->id,
                'company_id' => $task->company->id,
                'program_id' => $task->program->id,
                'title' => $task->title,
                'description' => $task->description,
                'available' => $task->available
            ]);
        }
    }
}
