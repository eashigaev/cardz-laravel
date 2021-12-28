<?php

namespace CardzApp\Api\Tests\Feature\Collect\Program;

use App\Models\Collect\Program;
use App\Models\User;
use CardzApp\Api\Shared\Presentation\Routes;
use CardzApp\Api\Tests\Support\ModuleTestTrait;
use Tests\TestCase;

class AddProgramTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_ADD_PROGRAM;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        $fixture = Program::factory()->make();
        $user = User::factory()->create();

        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, [
            'title' => $fixture->title,
            'description' => $fixture->description,
        ], [
            'company' => $fixture->company->id
        ]);
        $response->assertStatus(200);

        $result = Program::query()->findOrFail($response['id']);
        $this->assertArraySubset([
            'company_id' => $fixture->company->id,
            'title' => $fixture->title,
            'description' => $fixture->description,
            'available' => false
        ], $result->toArray());
    }
}
