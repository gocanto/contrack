<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Condominium;
use Illuminate\Database\Eloquent\Builder;

class CondominiumRepository
{
    public function findByUuid(string $uuid): ?Condominium
    {
        return $this->getBuilder()->where('uuid', $uuid)->first();
    }

    public function getBuilder(): Builder
    {
        return Condominium::query();
    }
}
