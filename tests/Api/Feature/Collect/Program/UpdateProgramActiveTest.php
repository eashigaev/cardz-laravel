<?php

namespace Tests\Api\Feature\Collect\Program;

use App\Models\Collect\Program;
use CardzApp\Api\Collect\Application\Events\ProgramActiveUpdated;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
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
        $program = Program::factory()->with(active: false)->create();

        $user = $program->company->founder;
        $this->actingAsSanctum($user);

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

        Event::assertDispatched(ProgramActiveUpdated::class);
    }
}
