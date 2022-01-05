<?php

namespace CardzApp\Api\Tests\Feature\Collect\Program;

use App\Models\Collect\Program;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use CardzApp\Api\Tests\Support\ModuleTestTrait;
use Tests\TestCase;

class GetProgramTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_GET_PROGRAM;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_GET_PROGRAM);
    }

    public function test_action()
    {
        $program = Program::factory()->create();

        $this->actingAsSanctum($program->company->founder);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'program' => $program->id
        ]);
        $response->assertStatus(200);

        $response->assertJson([
            'id' => $program->id,
            'company_id' => $program->company->id,
            'title' => $program->title,
            'description' => $program->description,
            'available' => $program->available
        ]);
    }
}
