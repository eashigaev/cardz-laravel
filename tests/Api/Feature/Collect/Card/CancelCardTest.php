<?php

namespace Tests\Api\Feature\Collect\Card;

use App\Models\Collect\Card;
use CardzApp\Api\Collect\Domain\CardStatus;
use CardzApp\Api\Collect\Domain\Messages;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use Tests\Api\Support\ModuleTestTrait;
use Tests\TestCase;

class CancelCardTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_CANCEL_CARD;

    use ModuleTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_CANCEL_CARD);
    }

    public function test_action()
    {
        $card = Card::factory()->create([
            'status' => CardStatus::ACTIVE->value
        ]);

        $user = $card->holder;
        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
        $response->assertStatus(200);

        $result = Card::query()->findOrFail($card->id);
        $this->assertArraySubset([
            'status' => CardStatus::CANCELLED->value
        ], $result->toArray());
    }

    public function test_fail_when_not_active()
    {
        $card = Card::factory()->create([
            'status' => CardStatus::REWARDED->value
        ]);

        $user = $card->holder;
        $this->actingAsSanctum($user);

        $this->expectExceptionMessage(Messages::CARD_MUST_BE_ACTIVE);

        $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
    }
}
