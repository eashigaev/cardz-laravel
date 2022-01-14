<?php

namespace Database\Factories\Collect;

use App\Models\Collect\Program;
use App\Models\Collect\Task;
use App\Models\Company;
use Codderz\YokoLite\Domain\Uuid\UuidTestTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    use UuidTestTrait;

    public $model = Task::class;

    public function definition()
    {
        $company = Company::factory();

        return [
            'id' => $this->uuidGenerator()->getNextValue(),
            'company_id' => $company,
            'program_id' => fn() => Program::factory()->for($company),
            'title' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'active' => $this->faker->boolean(),
            'repeatable' => $this->faker->boolean(),
        ];
    }
}
