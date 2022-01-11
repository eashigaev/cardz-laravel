<?php

namespace Tests\Api\Feature\Collect\Task;

use App\Models\Collect\Task;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class AddTaskTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_ADD_TASK;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_ADD_TASK);
    }

    public function test_action()
    {
        $fixture = Task::factory()->make();

        $this->actingAsCompany($fixture->company);

        $response = $this->callJsonRoute(self::ROUTE, [
            'title' => $fixture->title,
            'description' => $fixture->description,
            'repeatable' => $fixture->repeatable
        ], [
            'program' => $fixture->program->id
        ]);
        $response->assertStatus(200);

        $result = Task::query()->findOrFail($response['id']);
        $this->assertArraySubset([
            'company_id' => $fixture->company->id,
            'program_id' => $fixture->program->id,
            'title' => $fixture->title,
            'description' => $fixture->description,
            'repeatable' => $fixture->repeatable,
            'active' => false
        ], $result->toArray());
    }
}
