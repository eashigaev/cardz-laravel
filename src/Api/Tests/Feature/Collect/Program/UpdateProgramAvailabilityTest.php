<?php

namespace CardzApp\Api\Tests\Feature\Collect\Program;

use App\Models\Collect\Program;
use App\Models\User;
use CardzApp\Api\Shared\Presentation\Routes;
use CardzApp\Api\Tests\Support\ModuleTestTrait;
use Tests\TestCase;

class UpdateProgramAvailabilityTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_UPDATE_PROGRAM_AVAILABILITY;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        $program = Program::factory()->notAvailable()->create();
        $user = User::factory()->create();

        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, [
            'value' => true
        ], [
            'program' => $program->id
        ]);
        $response->assertStatus(200);

        $result = Program::query()->findOrFail($program->id);
        $this->assertArraySubset([
            'available' => true,
        ], $result->toArray());
    }
}
