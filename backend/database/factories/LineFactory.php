<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => $this->faker->word(),
            'rif'  => $this->faker->unique()->regexify('[a-z]{2}[0-9]{1}[A-Z]{2}[0-9]{2}'),
            'municipality_id' => $this->faker->rand(250,278)
        ];
    }
}
