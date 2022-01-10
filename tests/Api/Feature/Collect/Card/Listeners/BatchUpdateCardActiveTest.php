<?php

namespace Tests\Api\Feature\Collect\Card;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use CardzApp\Api\Collect\Application\Events\ProgramActiveUpdated;
use CardzApp\Api\Collect\Application\Listeners\BatchUpdateCardActive;
use CardzApp\Api\Collect\Domain\CardStatus;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class BatchUpdateCardActiveTest extends TestCase
{
    use FeatureTestTrait;

    public function test_update()
    {
        $this->flushEventListeners([BatchUpdateCardActive::class]);

        $program = Program::factory()->with(active: true)->create();

        $activeCard = Card::factory()->with(status: CardStatus::ACTIVE)->for($program)->create();
        $inactiveCard = Card::factory()->with(status: CardStatus::INACTIVE)->for($program)->create();
        $rewardedCard = Card::factory()->with(status: CardStatus::REWARDED)->for($program)->create();
        $otherProgramCard = Card::factory()->with(status: CardStatus::INACTIVE)->create();

        ProgramActiveUpdated::dispatch($program);

        $this->assertEquals(CardStatus::ACTIVE, CardStatus::tryFrom($activeCard->refresh()->status));
        $this->assertEquals(CardStatus::ACTIVE, CardStatus::tryFrom($inactiveCard->refresh()->status));
        $this->assertEquals(CardStatus::REWARDED, CardStatus::tryFrom($rewardedCard->refresh()->status));
        $this->assertEquals(CardStatus::INACTIVE, CardStatus::tryFrom($otherProgramCard->refresh()->status));

        $program->active = false;
        $program->save();

        ProgramActiveUpdated::dispatch($program->refresh());

        $this->assertEquals(CardStatus::INACTIVE, CardStatus::tryFrom($activeCard->refresh()->status));
        $this->assertEquals(CardStatus::INACTIVE, CardStatus::tryFrom($inactiveCard->refresh()->status));
        $this->assertEquals(CardStatus::REWARDED, CardStatus::tryFrom($rewardedCard->refresh()->status));
        $this->assertEquals(CardStatus::INACTIVE, CardStatus::tryFrom($otherProgramCard->refresh()->status));
    }
}
