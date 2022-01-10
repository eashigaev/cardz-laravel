<?php

namespace Database\Factories\Collect;

use App\Models\Collect\Card;
use App\Models\Collect\Achievement;
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
        $company = Company::factory()->create();
        $program = Program::factory()
            ->for($company, 'company')
            ->create();
        $task = Task::factory()
            ->for($company, 'company')->for($program, 'program')
            ->create();
        $card = Card::factory()
            ->for($company, 'company')->for($program, 'program')
            ->create();

        return [
            'id' => $this->uuidGenerator()->getNextValue(),
            'company_id' => $company,
            'program_id' => $program,
            'task_id' => $task,
            'card_id' => $card,
            'valid' => $this->faker->boolean()
        ];
    }

    public function with(bool $valid = false)
    {
        return $this->state(fn() => [
            'active' => $valid
        ]);
    }
}
