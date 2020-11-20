<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'number' => (string) $this->faker->unique()->randomNumber(2),
            'condominium_id' => null,
            'block_id' => null,
            'tenant_id' => null,
        ];
    }
}
