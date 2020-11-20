<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UnitRepository
{
    public function all(?int $limit = 20): Collection
    {
        return $this->getBuilder()->take($limit)->get();
    }

    public function findByUuid(string $uuid): ?Unit
    {
        return $this->getBuilder()->where('uuid', $uuid)->first();
    }

    public function getBuilder(): Builder
    {
        return Unit::with('condominium', 'block', 'tenant');
    }
}
