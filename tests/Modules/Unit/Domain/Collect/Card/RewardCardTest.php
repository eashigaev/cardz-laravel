<?php

namespace Tests\Modules\Unit\Domain\Collect\Card;

use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Collect\Domain\Messages;
use Illuminate\Support\Collection;
use Tests\Modules\Unit\Domain\Collect\CollectTestTrait;
use Tests\Modules\Unit\UnitTestTrait;
use Tests\TestCase;

class RewardCardTest extends TestCase
{
    use UnitTestTrait,
        CollectTestTrait;

    public function test_success()
    {
        $program = $this->makeProgram();
        $card = $this->makeCard($program);

        $this->assertTrue($card->status === CardStatus::ACTIVE);

        $card->reward($program);

        $this->assertTrue($card->status === CardStatus::REWARDED);
    }

    public function test_fail_when_non_active_card()
    {
        $program = $this->makeProgram();
        $card = $this->makeCard($program, status: CardStatus::REWARDED);

        $this->expectExceptionMessage(Messages::CARD_IS_NOT_ACTIVE);
        $card->reward($program);
    }

    public function test_fail_when_non_active_program()
    {
        $program = $this->makeProgram(active: false);
        $card = $this->makeCard($program);

        $this->expectExceptionMessage(Messages::PROGRAM_IS_NOT_ACTIVE);
        $card->reward($program);
    }

    public function test_fail_when_card_balance_is_not_enough()
    {
        $program = $this->makeProgram();
        $card = $this->makeCard($program, achievements: Collection::make());

        $this->expectExceptionMessage(Messages::CARD_BALANCE_IS_NOT_ENOUGH);
        $card->reward($program);
    }
}
