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
            'index_number' => $this->faker->word(),
            'program_id' => Program::factory(),
            'telephone' => $this->faker->word(),
            'level' => $this->faker->randomElement(["100","200","300","400","500","600"]),
            'program_type' => $this->faker->randomElement(["regular","top_up"]),
            'telcos_number' => $this->faker->word(),
            'serial_number' => $this->faker->word(),
            'expected_completion_year' => $this->faker->year(),
        ];
    }
}
