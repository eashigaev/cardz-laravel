<?php

namespace Database\Factories\Collect;

use App\Models\Collect\Program;
use App\Models\Company;
use Codderz\YokoLite\Domain\Uuid\UuidTestTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    use UuidTestTrait;

    public $model = Program::class;

    public function definition()
    {
        return [
            'id' => $this->uuidGenerator()->getNextValue(),
            'company_id' => Company::factory(),
            'title' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'available' => $this->faker->boolean()
        ];
    }

    public function with(bool $available = false)
    {
        return $this->state(fn() => [
            'available' => $available,
        ]);
    }
}
