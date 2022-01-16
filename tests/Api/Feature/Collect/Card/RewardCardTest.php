<?php

namespace Tests\Api\Feature\Collect\Card;

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Collect\Domain\Messages;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class RewardCardTest extends TestCase
{
    private const ROUTE = Routes::COLLECT_REWARD_CARD;

    use FeatureTestTrait;

    public function test_access()
    {
        $this->assertAuthenticatedRoute(self::ROUTE);
        $this->assertAuthorizedRoute(self::ROUTE, Actions::COLLECT_REWARD_CARD);
    }

    public function test_action()
    {
        $card = Card::factory()->withStatus(CardStatus::ACTIVE)
            ->has(Achievement::factory()->count(3))->create();
        $card->program()->update(['active' => true, 'reward_target' => 3]);

        $this->actingAsCompany($card->company);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
        $response->assertStatus(200);

        $result = Card::query()->findOrFail($card->id);
        $this->assertArraySubset([
            'balance' => 3,
            'status' => CardStatus::REWARDED->getValue()
        ], $result->toArray());
    }

    public function test_fail_when_card_is_not_active()
    {
        $card = Card::factory()->withStatus(CardStatus::REWARDED)->create();

        $this->actingAsCompany($card->company);

        $this->withoutExceptionHandling();
        $this->expectExceptionMessage(Messages::CARD_IS_NOT_ACTIVE);

        $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
    }

    public function test_fail_when_program_is_not_active()
    {
        $card = Card::factory()->withStatus(CardStatus::ACTIVE)->create();
        $card->program()->update(['active' => false]);

        $this->actingAsCompany($card->company);

        $this->withoutExceptionHandling();
        $this->expectExceptionMessage(Messages::PROGRAM_IS_NOT_ACTIVE);

        $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
    }

    public function test_fail_when_card_balance_is_not_enough()
    {
        $card = Card::factory()->withStatus(CardStatus::ACTIVE)->create();
        $card->program()->update(['active' => true, 'reward_target' => 1]);

        $this->actingAsCompany($card->company);

        $this->withoutExceptionHandling();
        $this->expectExceptionMessage(Messages::CARD_BALANCE_IS_NOT_ENOUGH);

        $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
    }
}
