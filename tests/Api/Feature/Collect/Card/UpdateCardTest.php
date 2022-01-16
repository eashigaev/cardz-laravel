<?php

namespace Tests\Api\Feature\Collect\Card;

use App\Models\Collect\Card;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Api\Feature\FeatureTestTrait;
use Tests\TestCase;

class UpdateCardTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_UPDATE_CARD;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_UPDATE_CARD);
    }

    public function test_action()
    {
        $fixture = Card::factory()->make();
        $card = Card::factory()->create();

        $this->actingAsCompany($card->company);

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
