<?php

namespace Database\Factories;

use App\Models\AnnualLeave;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnnualLeave>
 */
class AnnualLeaveFactory extends Factory
{
    protected $model = AnnualLeave::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'start_date' => date_format(fake()->dateTimeBetween('now', '+30 days'), 'Y-m-d'),
            'end_date' => date_format(fake()->dateTimeBetween('now', '+30 days'), 'Y-m-d'),
            'status' => fake()->randomElement(AnnualLeave::STATUS),
            'description' => fake()->sentence(),
        ];
    }
}
