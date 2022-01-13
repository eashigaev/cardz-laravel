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
            'description' => $this->faker->sentence(10),
            'reward_title' => $this->faker->streetName(),
            'reward_target' => $this->faker->numberBetween(1, 5),
            'active' => $this->faker->boolean()
        ];
    }
}
