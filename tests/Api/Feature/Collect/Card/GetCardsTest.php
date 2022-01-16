<?php

namespace Tests\Api\Feature\Collect\Card;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Api\Feature\FeatureTestTrait;
use Tests\TestCase;

class GetCardsTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_GET_CARDS;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_GET_CARDS);
    }

    public function test_action()
    {
        Card::factory()->count(4)->create();

        $program = Program::factory()->create();
        $cards = Card::factory()->for($program)->for($program->company)->count(4)->create();

        $this->actingAsCompany($program->company);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'program' => $program->id
        ]);
        $response->assertStatus(200);

        foreach ($cards as $card) {
            $response->assertJsonFragment([
                'id' => $card->id,
                'company_id' => $program->company_id,
                'company_title' => $program->company->title,
                'program_id' => $program->id,
                'program_title' => $program->title,
                'holder_id' => $card->holder_id,
                'balance' => $card->balance,
                'status' => $card->status
            ]);
        }
        $response->assertJsonCount(4);
    }
}
