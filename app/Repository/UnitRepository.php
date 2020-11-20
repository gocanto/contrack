<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Unit;
use Illuminate\Support\Collection;

class UnitRepository
{
    public function all(?int $limit = 20): Collection
    {
        return Unit::with('condominium', 'block', 'tenant')->take($limit)->get();
    }
}
