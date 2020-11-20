<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Condominium;
use Illuminate\Database\Eloquent\Factories\Factory;

class CondominiumFactory extends Factory
{
    protected $model = Condominium::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
