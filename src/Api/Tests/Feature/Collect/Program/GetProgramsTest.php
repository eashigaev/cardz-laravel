<?php

namespace CardzApp\Api\Tests\Feature\Collect\Program;

use App\Models\Collect\Program;
use App\Models\Company;
use CardzApp\Api\Shared\Presentation\Routes;
use CardzApp\Api\Tests\Support\ModuleTestTrait;
use Tests\TestCase;

class GetProgramsTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_GET_PROGRAMS;

    use ModuleTestTrait;

    public function test_action()
    {
        $company = Company::factory()->create();
        $programs = Program::factory()->for($company)->count(3)->create();

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
        $available = Program::factory()->for($company)->available()->count(3)->create();
        Program::factory()->for($company)->notAvailable()->count(2)->create();

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
