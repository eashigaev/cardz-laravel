<?php

namespace Tests\Feature\Api\Wallet;

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use App\Models\Collect\Program;
use CardzApp\Api\Shared\Routes;
use Tests\Feature\Api\FeatureTestTrait;
use Tests\TestCase;

class GetOwnCardTest extends TestCase
{
    private const ROUTE = Routes::WALLET_GET_OWN_CARD;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
    }

    public function test_action()
    {
        $program = Program::factory()->create();
        $card = Card::factory()->forProgram($program)->has(Achievement::factory()->count(3))->create();

        $this->actingAsSanctum($card->holder);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
        $response->assertStatus(200);

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

        foreach ($card->achievements as $achievement) {
            $response->assertJsonFragment([
                'id' => $achievement->id,
                'task_title' => $achievement->task->title,
                'created_at' => $achievement->created_at->toString()
            ]);
        }
    }
}
