<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Program;
use App\Models\School;

class ProgramFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Program::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'regular_duration' => $this->faker->numberBetween(-10000, 10000),
            'top_up_duration' => $this->faker->numberBetween(-10000, 10000),
            'has_top_up' => $this->faker->boolean(),
            'program_code' => $this->faker->word(),
            'school_id' => School::factory(),
        ];
    }
}
