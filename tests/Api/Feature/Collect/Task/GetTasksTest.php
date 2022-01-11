<?php

namespace Tests\Api\Feature\Collect\Task;

use App\Models\Collect\Program;
use App\Models\Collect\Task;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class GetTasksTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_GET_TASKS;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_GET_TASKS);
    }

    public function test_action()
    {
        $program = Program::factory()->create();
        $tasks = Task::factory()->for($program)->count(3)->create();

        $user = $program->company->founder;
        $this->actingAsSanctum($user);

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
                'active' => $task->active
            ]);
        }
    }
}