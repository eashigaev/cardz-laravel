<?php

namespace Tests\Api\Feature\Collect\Program;

use App\Models\Collect\Program;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Collect\Application\Events\ProgramActiveUpdated;
use CardzApp\Modules\Shared\Application\Actions;
use Event;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class UpdateProgramActiveTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_UPDATE_PROGRAM_ACTIVE;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_UPDATE_PROGRAM_ACTIVE);
    }

    public function test_action()
    {
        $program = Program::factory()->create(['active' => false]);

        $this->actingAsCompany($program->company);

        Event::fake();

        $response = $this->callJsonRoute(self::ROUTE, [
            'value' => true
        ], [
            'program' => $program->id
        ]);
        $response->assertStatus(200);

        $result = Program::query()->findOrFail($program->id);
        $this->assertArraySubset([
            'active' => true
        ], $result->toArray());
    }
}
