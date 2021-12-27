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
            'tenant_id' => Company::factory(),
            'title' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'available' => $this->faker->boolean()
        ];
    }

    public function added()
    {
        return $this->notAvailable();
    }

    public function notAvailable()
    {
        return $this->state(function (array $attributes) {
            return ['available' => false];
        });
    }

    public function available()
    {
        return $this->state(function (array $attributes) {
            return ['available' => true];
        });
    }

    //

    public function forTenant(Company $model)
    {
        return $this->for($model, 'tenant');
    }
}
