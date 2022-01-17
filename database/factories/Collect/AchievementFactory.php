<?php

namespace Database\Factories\Collect;

use App\Models\Collect\Achievement;
use App\Models\Collect\Card;
use App\Models\Collect\Program;
use App\Models\Collect\Task;
use App\Models\Company;
use Codderz\YokoLite\Domain\Uuid\UuidTestTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class AchievementFactory extends Factory
{
    use UuidTestTrait;

    public $model = Achievement::class;

    public function definition()
    {
        return [
            'id' => $this->uuidGenerator()->getNextValue(),
            'company_id' => Company::factory(),
            'program_id' => fn($attrs) => Program::factory()
                ->state(['company_id' => $attrs['company_id']]),
            'task_id' => fn($attrs) => Task::factory()
                ->state(['company_id' => $attrs['company_id']])
                ->state(['program_id' => $attrs['program_id']]),
            'card_id' => fn($attrs) => Card::factory()
                ->state(['company_id' => $attrs['company_id']])
                ->state(['program_id' => $attrs['program_id']])
        ];
    }
}
