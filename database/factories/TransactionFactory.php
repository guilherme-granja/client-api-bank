<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'type' => fake()->randomElement(['credit', 'debit']),
            'amount' => fake()->randomFloat(2, 1, 1000),
            'description' => fake()->optional()->sentence(),
            'meta' => fake()->optional()->randomElement([null, ['ip' => fake()->ipv4(), 'agent' => fake()->userAgent()]]),
            'reference' => (string) Str::uuid(),
        ];
    }
}
