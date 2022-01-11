<?php

namespace Tests\Api\Feature\Collect\Card;

use App\Models\Collect\Card;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Collect\Domain\Messages;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class RejectCardTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_REJECT_CARD;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_REJECT_CARD);
    }

    public function test_action()
    {
        $card = Card::factory()->create([
            'status' => CardStatus::ACTIVE->value
        ]);

        $this->actingAsCompany($card->company);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
        $response->assertStatus(200);

        $result = Card::query()->findOrFail($card->id);
        $this->assertArraySubset([
            'status' => CardStatus::REJECTED->value
        ], $result->toArray());
    }

    public function test_fail_when_not_active()
    {
        $card = Card::factory()->create([
            'status' => CardStatus::REWARDED->value
        ]);

        $this->actingAsCompany($card->company);

        $this->withoutExceptionHandling();
        $this->expectExceptionMessage(Messages::CARD_IS_NOT_ACTIVE);

        $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
    }
}
