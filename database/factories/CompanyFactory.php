<?php

namespace Database\Factories;

use App\Models\User;
use Codderz\YokoLite\Domain\Uuid\UuidTestTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    use UuidTestTrait;

    public function definition()
    {
        return [
            'id' => $this->uuidGenerator()->getNextValue(),
            'founder_id' => User::factory(),
            'title' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'about' => $this->faker->text()
        ];
    }
}
