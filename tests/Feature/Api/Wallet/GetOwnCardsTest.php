<?php

namespace Tests\Feature\Api\Wallet;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use App\Models\User;
use CardzApp\Api\Shared\Routes;
use Tests\Feature\Api\FeatureTestTrait;
use Tests\TestCase;

class GetOwnCardsTest extends TestCase
{
    private const ROUTE = Routes::WALLET_GET_OWN_CARDS;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        Card::factory()->count(4)->create();

        $holder = User::factory()->create();
        $program = Program::factory()->create();
        $cards = Card::factory()->forProgram($program)->for($holder, 'holder')->count(4)->create();

        $this->actingAsSanctum($holder);

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

        $holder = User::factory()->create();
        $program = Program::factory()->create();
        $cards = Card::factory()->forProgram($program)->for($holder, 'holder')->count(12)->create();

        $this->actingAsSanctum($holder);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
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
