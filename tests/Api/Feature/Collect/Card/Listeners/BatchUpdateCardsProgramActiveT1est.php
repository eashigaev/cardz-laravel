<?php

namespace Tests\Api\Feature\Collect\Card\Listeners;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use CardzApp\Modules\Collect\Application\Listeners\UpdateCardBalance;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class BatchUpdateCardsProgramActiveT1est extends TestCase
{
    use FeatureTestTrait;

    public function test_update()
    {
        $this->flushEventListeners([UpdateCardBalance::class]);

        $program = Program::factory()->with(active: true)->create();

        $programCard = Card::factory()->with()->for($program)->create();
        $otherCard = Card::factory()->with()->create();

        ProgramActiveUpdated::dispatch($program);

        $this->assertEquals(true, $programCard->refresh()->program_active);
        $this->assertEquals(false, $otherCard->refresh()->program_active);

        $program->active = false;
        $program->save();

        ProgramActiveUpdated::dispatch($program->refresh());

        $this->assertEquals(false, $programCard->refresh()->program_active);
        $this->assertEquals(false, $otherCard->refresh()->program_active);
    }
}
