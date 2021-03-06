<?php

namespace Tests\Feature\Api\Collect\Card;

use App\Models\Collect\Card;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Collect\Domain\Messages;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Feature\Api\FeatureTestTrait;
use Tests\TestCase;

class CancelCardTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_CANCEL_CARD;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_CANCEL_CARD);
    }

    public function test_action()
    {
        $card = Card::factory()->withStatus(CardStatus::ACTIVE)->create();

        $user = $card->holder;
        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
        $response->assertStatus(200);

        $result = Card::query()->findOrFail($card->id);
        $this->assertArraySubset([
            'status' => CardStatus::CANCELLED->getValue()
        ], $result->toArray());
    }

    public function test_fail_when_not_active()
    {
        $card = Card::factory()->withStatus(CardStatus::REWARDED)->create();

        $user = $card->holder;
        $this->actingAsSanctum($user);

        $this->withoutExceptionHandling();
        $this->expectExceptionMessage(Messages::CARD_IS_NOT_ACTIVE);

        $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
    }
}
