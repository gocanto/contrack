<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Block;
use App\Models\Condominium;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\Visit;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        /** @var Condominium $condominium */
        $condominium = Condominium::factory()->create([
            'name' => 'Augusto Malave Villalba',
        ]);

        /** @var Block $block */
        $block = Block::factory()->create([
            'condominium_id' => $condominium->id,
            'number' => '02',
        ]);

        /** @var Tenant $tenant */
        $tenant = Tenant::factory()->create([
            'first_name' => 'Gustavo',
            'last_name' => 'Ocanto',
        ]);

        /** @var Unit $unit */
        $unit = Unit::factory()->create([
            'number' => '06-02',
            'tenant_id' => $tenant->id,
            'block_id' => $block->id,
            'condominium_id' => $condominium->id,
        ]);

        Visit::factory()->create([
            'condominium_id' => $condominium->id,
            'block_id' => $block->id,
            'unit_id' => $unit->id,
            'arrived_at' => $now,
            'left_at' => $now->addHours(2),
        ]);

        Visit::factory()->create([
            'condominium_id' => $condominium->id,
            'block_id' => $block->id,
            'unit_id' => $unit->id,
            'arrived_at' => $now,
        ]);
    }
}
