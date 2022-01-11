<?php

namespace Tests\Api\Feature\Collect\Card;

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
        $card = Card::factory()->create([
            'status' => CardStatus::ACTIVE->value, 'balance' => 5
        ]);
        $card->program()->update([
            'active' => true, 'reward_target' => 5
        ]);

        $user = $card->company->founder;
        $this->actingAsSanctum($user);

        $response = $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
        $response->assertStatus(200);

        $result = Card::query()->findOrFail($card->id);
        $this->assertArraySubset([
            'balance' => 0,
            'status' => CardStatus::REWARDED->value
        ], $result->toArray());
    }

    public function test_fail_when_card_is_not_active()
    {
        $card = Card::factory()->create([
            'status' => CardStatus::REWARDED->value
        ]);

        $user = $card->company->founder;
        $this->actingAsSanctum($user);

        $this->withoutExceptionHandling();
        $this->expectExceptionMessage(Messages::CARD_IS_NOT_ACTIVE);

        $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
    }

    public function test_fail_when_program_is_not_active()
    {
        $card = Card::factory()->create([
            'status' => CardStatus::ACTIVE->value
        ]);
        $card->program()->update([
            'active' => false
        ]);

        $user = $card->company->founder;
        $this->actingAsSanctum($user);

        $this->withoutExceptionHandling();
        $this->expectExceptionMessage(Messages::PROGRAM_IS_NOT_ACTIVE);

        $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
    }

    public function test_fail_when_card_balance_is_not_enough()
    {
        $card = Card::factory()->create([
            'status' => CardStatus::ACTIVE->value, 'balance' => 0
        ]);
        $card->program()->update([
            'active' => true, 'reward_target' => 1
        ]);

        $user = $card->company->founder;
        $this->actingAsSanctum($user);

        $this->withoutExceptionHandling();
        $this->expectExceptionMessage(Messages::CARD_BALANCE_IS_NOT_ENOUGH);

        $this->callJsonRoute(self::ROUTE, parameters: [
            'card' => $card->id
        ]);
    }
}
