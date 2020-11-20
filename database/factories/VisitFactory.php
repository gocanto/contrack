<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VisitFactory extends Factory
{
    protected $model = Visit::class;

    public function definition(): array
    {
        return [
            'visitor_first_name' => $this->faker->firstName,
            'visitor_last_name' => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'nric_last_r' => Str::random(3),
            'unit_id' => null,
            'block_id' => null,
        ];
    }
}
