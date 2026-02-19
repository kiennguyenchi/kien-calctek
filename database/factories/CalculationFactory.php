<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CalculationFactory extends Factory
{
    public function definition(): array
    {
        $num1 = $this->faker->numberBetween(1, 100);
        $num2 = $this->faker->numberBetween(1, 100);

        return [
            'expression' => "$num1 + $num2",
            'result' => $num1 + $num2,
        ];
    }
}
