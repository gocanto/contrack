<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;

class TenantRepository
{
    public function findByUuid(string $uuid): ?Tenant
    {
        return $this->getBuilder()->where('uuid', $uuid)->first();
    }

    public function getBuilder(): Builder
    {
        return Tenant::query();
    }
}
