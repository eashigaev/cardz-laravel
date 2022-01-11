<?php

namespace Tests\Api\Feature\Collect\Card\Listeners;

use App\Models\Collect\Card;
use App\Models\Collect\Program;
use CardzApp\Api\Collect\Application\Events\ProgramActiveUpdated;
use CardzApp\Api\Collect\Application\Listeners\BatchUpdateCardsProgramActive;
use Tests\Api\Support\FeatureTestTrait;
use Tests\TestCase;

class BatchUpdateCardsProgramActiveTest extends TestCase
{
    use FeatureTestTrait;

    public function test_update()
    {
        $this->flushEventListeners([BatchUpdateCardsProgramActive::class]);

        $program = Program::factory()->with(active: true)->create();

        $programCard = Card::factory()->with(program_active: false)->for($program)->create();
        $otherCard = Card::factory()->with(program_active: false)->create();

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
