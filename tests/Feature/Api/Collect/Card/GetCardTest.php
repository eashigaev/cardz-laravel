<?php

namespace Tests\Feature\Api\Collect\Card;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Feature\Api\FeatureTestTrait;
use Tests\TestCase;

class GetCardTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_GET_CARD;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_GET_CARD);
    }

    public function test_action()
    {
        $program = Program::factory()->create();
        $card = Card::factory()->for($program)->for($program->company)->create();

        $this->actingAsCompany($program->company);

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
            'holder_username' => $card->holder->username,
            'comment' => $card->comment,
            'balance' => $card->balance,
            'status' => $card->status
        ]);
    }
}
