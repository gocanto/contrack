<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Block;
use App\Models\Unit;
use App\Models\Visit;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class VisitRepository
{
    public function findByUuid(string $uuid): ?Visit
    {
        return $this->getBuilder()->where('uuid', $uuid)->first();
    }

    public function all(array $filters = []): Collection
    {
        $allowedFilters = ['phone_number', 'limit'];

        $filters = Collection::make($filters)
            ->reject(static fn ($item, $key) => empty($item) || !in_array($key, $allowedFilters, true));

        $items = $this->getBuilder();

        if (isset($filters['phone_number'])) {
            $items->where('phone_number', $filters['phone_number']);
        }

        $from = CarbonImmutable::now()->subMonths(3);
        $limit = isset($filters['limit']) && $filters['limit'] <= 100 ? $filters['limit'] : 100;

        return $items->where('arrived_at', '>=', $from)
            ->take($limit)
            ->get();
    }

    public function create(Block $block, Unit $unit, array $data): Visit
    {
        return Visit::create(array_merge($data, [
            'condominium_id' => $unit->condominium->id,
            'arrived_at' => CarbonImmutable::now(),
            'block_id' => $block->id,
            'unit_id' => $unit->id,
        ]));
    }

    public function hasVisitor(Unit $unit, string $nric): bool
    {
        return $this->getBuilder()
            ->where('block_id', $unit->block->id)
            ->where('unit_id', $unit->id)
            ->where('nric_last_r', $nric)
            ->whereNull('left_at')
            ->exists();
    }

    public function findByNricAndUuid(string $number, string $uuid): ?Visit
    {
        return $this->getBuilder()->where('nric_last_r', $number)->where('uuid', $uuid)->first();
    }

    public function updateCapacity(Visit $visit): Visit
    {
        $visit->left_at = CarbonImmutable::now();
        $visit->save();

        return $visit->fresh();
    }

    private function getBuilder(): Builder
    {
        return Visit::with('condominium', 'block', 'unit');
    }
}
