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
        $company = Company::factory();
        $program = Program::factory()->for($company);

        return [
            'id' => $this->uuidGenerator()->getNextValue(),
            'company_id' => $company,
            'program_id' => $program,
            'task_id' => Task::factory()->for($company)->for($program),
            'card_id' => Card::factory()->for($company)->for($program)
        ];
    }
}
