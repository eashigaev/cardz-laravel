<?php

namespace Tests\Feature\Api\Collect\Program;

use App\Models\Collect\Program;
use App\Models\Company;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Feature\Api\FeatureTestTrait;
use Tests\TestCase;

class GetProgramsTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_GET_PROGRAMS;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_GET_PROGRAMS);
    }

    public function test_action()
    {
        $company = Company::factory()->create();
        $programs = Program::factory()->for($company)->count(3)->create();

        $this->actingAsCompany($company);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'company' => $company->id
        ]);
        $response->assertStatus(200);

        foreach ($programs as $program) {
            $response->assertJsonFragment([
                'id' => $program->id,
                'company_id' => $program->company->id,
                'title' => $program->title,
                'description' => $program->description,
                'active' => $program->active
            ]);
        }
    }

    public function test_filter_active()
    {
        $company = Company::factory()->create();
        $active = Program::factory()->for($company)->count(3)->create(['active' => true]);
        Program::factory()->for($company)->count(2)->create(['active' => false]);

        $this->actingAsCompany($company);

        $response = $this->callJsonRoute(self::ROUTE,
            ['active' => true],
            ['company' => $company->id]
        );
        $response->assertStatus(200);
        $response->assertJsonCount($active->count());

        foreach ($active as $program) {
            $response->assertJsonFragment([
                'id' => $program->id
            ]);
        }
    }
}
