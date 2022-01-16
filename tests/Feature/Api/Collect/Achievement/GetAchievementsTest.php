<?php

namespace Tests\Feature\Api\Collect\Achievement;

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Feature\Api\FeatureTestTrait;
use Tests\TestCase;

class GetAchievementsTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_GET_ACHIEVEMENTS;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_GET_ACHIEVEMENTS);
    }

    public function test_action()
    {
        $card = Card::factory()->has(Achievement::factory()->count(3))->create();

        $this->actingAsCompany($card->company);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
        $response->assertStatus(200);

        foreach ($card->achievements as $achievement) {
            $response->assertJsonFragment([
                'id' => $achievement->id,
                'company_id' => $achievement->company->id,
                'program_id' => $achievement->program->id,
                'title' => $achievement->task->title,
                'created_at' => $achievement->created_at->toString()
            ]);
        }
    }
}
