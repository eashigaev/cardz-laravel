<?php

namespace Tests\Feature\Api\Collect\Card;

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use CardzApp\Api\Shared\Routes;
use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Shared\Application\Actions;
use Tests\Feature\Api\FeatureTestTrait;
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
}
