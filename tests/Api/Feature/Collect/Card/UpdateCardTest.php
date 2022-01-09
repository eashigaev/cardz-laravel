<?php

namespace Tests\Api\Feature\Collect\Card;

use App\Models\Collect\Card;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use Tests\Api\Support\ModuleTestTrait;
use Tests\TestCase;

class UpdateCardTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_UPDATE_CARD;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_UPDATE_CARD);
    }

    public function test_action()
    {
        $fixture = Card::factory()->make();
        $card = Card::factory()->create();

        $user = $card->company->founder;
        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, [
            'comment' => $fixture->comment
        ], [
            'card' => $card->id
        ]);
        $response->assertStatus(200);

        $result = Card::query()->findOrFail($card->id);
        $this->assertArraySubset([
            'comment' => $fixture->comment,
        ], $result->toArray());
    }
}
