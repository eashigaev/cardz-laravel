<?php

namespace Tests\Unit\Modules\Domain\Collect\Achievement;

use CardzApp\Modules\Collect\Domain\CardStatus;
use CardzApp\Modules\Collect\Domain\Messages;
use Codderz\YokoLite\Domain\Uuid\Uuid;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Unit\Modules\Domain\Collect\CollectTestTrait;
use Tests\Unit\Modules\UnitTestTrait;

class AddAchievementTest extends TestCase
{
    use UnitTestTrait,
        CollectTestTrait;

    public function test_success_when_repeatable()
    {
        $program = $this->makeProgram();
        $card = $this->makeCard($program);

        $task = $program->tasks->first();
        $card->achievements->pop();

        $this->assertEquals(2, $card->getBalance());

        $card->addAchievement(
            Uuid::of($this->uuidGenerator()->getNextValue()),
            $task->id,
            $program
        );

        $this->assertEquals(3, $card->getBalance());
    }

    public function test_success_when_non_repeatable()
    {
        $program = $this->makeProgram();
        $card = $this->makeCard($program);

        $task = $this->makeTask(false, true);
        $program->tasks = $program->tasks->add($task);
        $card->achievements->pop();

        $this->assertEquals(2, $card->getBalance());

        $card->addAchievement(
            Uuid::of($this->uuidGenerator()->getNextValue()),
            $task->id,
            $program
        );

        $this->assertEquals(3, $card->getBalance());
    }

    public function test_fail_when_non_repeatable_task_is_already_completed()
    {
        $program = $this->makeProgram();
        $task = $this->makeTask(repeatable: false);
        $program->tasks = Collection::make([$task]);

        $card = $this->makeCard($program);
        $achievement = $this->makeAchievement(taskId: $task->id);
        $card->achievements = Collection::make([$achievement]);

        $this->expectExceptionMessage(Messages::CARD_TASK_ALREADY_ACHIEVED);

        $card->addAchievement(
            Uuid::of($this->uuidGenerator()->getNextValue()),
            $task->id,
            $program
        );
    }

    public function test_fail_when_non_active_card()
    {
        $program = $this->makeProgram();
        $card = $this->makeCard($program, status: CardStatus::REWARDED);

        $this->expectExceptionMessage(Messages::CARD_IS_NOT_ACTIVE);

        $card->addAchievement(
            Uuid::of($this->uuidGenerator()->getNextValue()),
            Uuid::of($this->uuidGenerator()->getNextValue()),
            $program
        );
    }

    public function test_fail_when_non_active_program()
    {
        $program = $this->makeProgram(active: false);
        $card = $this->makeCard($program);

        $this->expectExceptionMessage(Messages::PROGRAM_IS_NOT_ACTIVE);

        $card->addAchievement(
            Uuid::of($this->uuidGenerator()->getNextValue()),
            Uuid::of($this->uuidGenerator()->getNextValue()),
            $program
        );
    }

    public function test_fail_when_program_target_was_already_reached()
    {
        $program = $this->makeProgram();
        $card = $this->makeCard($program);

        $this->expectExceptionMessage(Messages::PROGRAM_TARGET_ALREADY_REACHED);

        $card->addAchievement(
            Uuid::of($this->uuidGenerator()->getNextValue()),
            $program->tasks->first()->id,
            $program
        );
    }

    public function test_fail_when_program_target_was_task_not_found()
    {
        $program = $this->makeProgram();
        $card = $this->makeCard($program);
        $card->achievements->pop();

        $this->expectExceptionMessage(Messages::NOT_FOUND);

        $card->addAchievement(
            Uuid::of($this->uuidGenerator()->getNextValue()),
            Uuid::of($this->uuidGenerator()->getNextValue()),
            $program
        );
    }

    public function test_fail_when_task_is_not_active()
    {
        $program = $this->makeProgram();
        $task = $this->makeTask(active: false);
        $program->tasks->add($task);

        $card = $this->makeCard($program);
        $card->achievements->pop();

        $this->expectExceptionMessage(Messages::TASK_IS_NOT_ACTIVE);

        $card->addAchievement(
            Uuid::of($this->uuidGenerator()->getNextValue()),
            $task->id,
            $program
        );
    }
}
