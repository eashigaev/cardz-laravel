<?php

namespace Tests\Api\Feature\Collect\Task;

use App\Models\Collect\Task;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Api\Feature\FeatureTestTrait;
use Tests\TestCase;

class UpdateTaskActiveTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_UPDATE_TASK_ACTIVE;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_UPDATE_TASK_ACTIVE);
    }

    public function test_action()
    {
        $task = Task::factory()->create(['active' => false]);

        $this->actingAsCompany($task->company);

        $response = $this->callJsonRoute(self::ROUTE, [
            'value' => true
        ], [
            'task' => $task->id
        ]);
        $response->assertStatus(200);

        $result = Task::query()->findOrFail($task->id);
        $this->assertArraySubset([
            'active' => true,
        ], $result->toArray());
    }
}
