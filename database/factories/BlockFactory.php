<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Block;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlockFactory extends Factory
{
    protected $model = Block::class;

    public function definition(): array
    {
        return [
            'condominium_id' => null,
            'number' => (string) $this->faker->randomNumber(2),
        ];
    }
}
