<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Block;
use App\Models\Condominium;
use App\Models\Tenant;
use App\Models\Unit;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UnitRepository
{
    public function create(array $data): Unit
    {
        return Unit::create($data);
    }

    public function update(Unit $unit, array $data): Unit
    {
        $unit->update($data);

        return $unit->fresh();
    }

    /**
     * @throws Exception
     */
    public function delete(Unit $unit): void
    {
        $unit->delete();
    }

    public function all(?int $limit = 20): Collection
    {
        return $this->getBuilder()->take($limit ?? 50)->get();
    }

    public function findBy(Condominium $condominium, Block $block, string $uuid): ?Unit
    {
        /** @var Unit $unit */
        $unit = $this->getBuilder()
            ->where('condominium_id', $condominium->id)
            ->where('block_id', $block->id)
            ->where('uuid', 'like', $uuid)
            ->first();

        return $unit;
    }

    public function findByUuid(string $uuid): ?Unit
    {
        return $this->getBuilder()->where('uuid', $uuid)->first();
    }

    public function findByNumber(string $number): ?Unit
    {
        return $this->getBuilder()->where('number', $number)->first();
    }

    public function markAsRented(Unit $unit, Tenant $tenant): Unit
    {
        $unit->rent($tenant);

        return $unit->fresh();
    }

    public function markAsAvailable(Unit $unit): Unit
    {
        $unit->tenant_id = null;
        $unit->save();

        return $unit->fresh();
    }

    private function getBuilder(): Builder
    {
        return Unit::with('condominium', 'block', 'tenant');
    }
}
