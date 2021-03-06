<?php

namespace Database\Factories\Collect;

use App\Models\Collect\Program;
use App\Models\Collect\Task;
use App\Models\Company;
use Codderz\YokoLite\Domain\Uuid\UuidTestTrait;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class TaskFactory extends Factory
{
    use UuidTestTrait;

    public $model = Task::class;

    public function definition()
    {
        return [
            'id' => $this->uuidGenerator()->getNextValue(),
            'company_id' => Company::factory()->create(),
            'program_id' => fn($attrs) => Program::factory()
                ->state(['company_id' => $attrs['company_id']]),
            'title' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'active' => $this->faker->boolean(),
            'repeatable' => $this->faker->boolean(),
        ];
    }

    public function forProgram(Model|Program $program)
    {
        return $this->state(fn() => [
            'company_id' => $program->company_id,
            'program_id' => $program->id,
        ]);
    }
}
