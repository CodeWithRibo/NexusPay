<?php

namespace Database\Factories;

use App\Models\StudentBalance;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StudentBalanceFactory extends Factory
{
    protected $model = StudentBalance::class;

    public function definition(): array
    {
        return [
            'fee_name' => $this->faker->name(),
            'total_amount' => $this->faker->randomFloat(),
            'paid_amount' => $this->faker->randomFloat(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
