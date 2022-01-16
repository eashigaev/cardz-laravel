<?php

namespace Tests\Api\Feature\Collect\Task;

use App\Models\Collect\Task;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Api\Feature\FeatureTestTrait;
use Tests\TestCase;

class GetTaskTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_GET_TASK;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_GET_TASK);
    }

    public function test_action()
    {
        $task = Task::factory()->create();

        $this->actingAsCompany($task->company);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'task' => $task->id
        ]);
        $response->assertStatus(200);

        $response->assertJson([
            'id' => $task->id,
            'company_id' => $task->company->id,
            'program_id' => $task->program->id,
            'title' => $task->title,
            'description' => $task->description,
            'active' => $task->active
        ]);
    }
}
