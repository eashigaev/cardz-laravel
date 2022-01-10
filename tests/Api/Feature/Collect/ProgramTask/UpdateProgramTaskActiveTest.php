<?php

namespace Tests\Api\Feature\Collect\ProgramTask;

use App\Models\Collect\ProgramTask;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class UpdateProgramTaskActiveTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_UPDATE_PROGRAM_TASK_ACTIVE;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_UPDATE_PROGRAM_TASK_ACTIVE);
    }

    public function test_action()
    {
        $task = ProgramTask::factory()->with(active: false)->create();

        $user = $task->company->founder;
        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, [
            'value' => true
        ], [
            'task' => $task->id
        ]);
        $response->assertStatus(200);

        $result = ProgramTask::query()->findOrFail($task->id);
        $this->assertArraySubset([
            'active' => true,
        ], $result->toArray());
    }
}