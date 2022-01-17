<?php

namespace Tests\Feature\Api\Collect\Card;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Feature\Api\FeatureTestTrait;
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
        $response->assertJsonCount(4, 'items');
    }

    public function test_pagination()
    {
        Card::factory()->count(4)->create();

        $program = Program::factory()->create();
        $cards = Card::factory()->for($program)->for($program->company)->count(12)->create();

        $this->actingAsCompany($program->company);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'program' => $program->id,
            'page' => 2
        ]);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'page' => 2,
            'count_items' => $cards->count(),
            'count_pages' => 2,
            'per_page' => 10
        ]);
    }
}
