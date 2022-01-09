<?php

namespace Tests\Api\Feature\Collect\ProgramTask;

use App\Models\Collect\ProgramTask;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class UpdateProgramTaskTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_UPDATE_PROGRAM_TASK;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_UPDATE_PROGRAM_TASK);
    }

    public function test_action()
    {
        $fixture = ProgramTask::factory()->make();
        $task = ProgramTask::factory()->create();

        $user = $task->company->founder;
        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, [
            'title' => $fixture->title,
            'description' => $fixture->description,
            'repeatable' => $fixture->repeatable
        ], [
            'task' => $task->id
        ]);
        $response->assertStatus(200);

        $result = ProgramTask::query()->findOrFail($task->id);
        $this->assertArraySubset([
            'title' => $fixture->title,
            'description' => $fixture->description,
            'repeatable' => $fixture->repeatable
        ], $result->toArray());
    }
}
