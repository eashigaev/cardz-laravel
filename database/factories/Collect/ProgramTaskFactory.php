<?php

namespace Database\Factories\Collect;

use App\Models\Collect\Program;
use App\Models\Collect\ProgramTask;
use App\Models\Company;
use Codderz\YokoLite\Domain\Uuid\UuidTestTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramTaskFactory extends Factory
{
    use UuidTestTrait;

    public $model = ProgramTask::class;

    public function definition()
    {
        $company = Company::factory()->create();

        return [
            'id' => $this->uuidGenerator()->getNextValue(),
            'company_id' => $company,
            'program_id' => Program::factory()->for($company),
            'title' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'available' => $this->faker->boolean(),
            'repeatable' => $this->faker->boolean(),
        ];
    }

    public function set(bool $available = false, bool $repeatable = false)
    {
        return $this->state(fn() => [
            'available' => $available,
            'repeatable' => $repeatable
        ]);
    }
}
