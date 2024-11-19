<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Program;
use App\Models\Student;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'student_id' => $this->faker->word(),
            'program_id' => Program::factory(),
            'telephone' => $this->faker->word(),
            'level' => $this->faker->numberBetween(-10000, 10000),
            'program_type:enum' => $this->faker->word(),
            'telcost_number' => $this->faker->word(),
            'expected_completion_year' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
