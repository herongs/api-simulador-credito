<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Simulations>
 */
class SimulationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'loan_amount' => $this->faker->numberBetween(1000, 100000),
        'payment_date' => $this->faker->date(),
        'birth_date' => $this->faker->date(),
        'interest_rate' => $this->faker->randomFloat(2, 0, 0.2),
        'interest_type' => $this->faker->randomElement(['FIXA', 'VARIAVEL']),
        'total_amount' => $this->faker->numberBetween(1000, 100000),
        'monthly_payment' => $this->faker->numberBetween(100, 10000),
        'total_interest' => $this->faker->numberBetween(100, 10000),
        'total_payment' => $this->faker->numberBetween(1000, 100000),
        'currency' => $this->faker->currencyCode,
        ];
    }
}
