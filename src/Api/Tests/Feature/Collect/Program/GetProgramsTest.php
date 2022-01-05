<?php

namespace CardzApp\Api\Tests\Feature\Collect\Program;

use App\Models\Collect\Program;
use App\Models\Company;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use CardzApp\Api\Tests\Support\ModuleTestTrait;
use Tests\TestCase;

class GetProgramsTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_GET_PROGRAMS;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_GET_PROGRAMS);
    }

    public function test_action()
    {
        $company = Company::factory()->create();
        $programs = Program::factory()->for($company)->count(3)->create();

        $this->actingAsSanctum($company->founder);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'company' => $company->id
        ]);
        $response->assertStatus(200);

        foreach ($programs as $program) {
            $response->assertJsonFragment([
                'id' => $program->id,
                'title' => $program->title,
                'description' => $program->description,
                'available' => $program->available
            ]);
        }
    }

    public function test_filter_available()
    {
        $company = Company::factory()->create();
        $available = Program::factory()->for($company)->with(available: true)->count(3)->create();
        Program::factory()->for($company)->with(available: false)->count(2)->create();

        $this->actingAsSanctum($company->founder);

        $response = $this->callJsonRoute(self::ROUTE,
            ['available' => true],
            ['company' => $company->id]
        );
        $response->assertStatus(200);
        $response->assertJsonCount($available->count());

        foreach ($available as $program) {
            $response->assertJsonFragment([
                'id' => $program->id
            ]);
        }
    }
}
