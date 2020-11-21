<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Throwable;

class TenantRepository
{
    public function findByUuid(string $uuid): ?Tenant
    {
        return $this->getBuilder()->where('uuid', $uuid)->first();
    }

    public function create(array $data): Tenant
    {
        return Tenant::create($this->getAttributes($data));
    }

    public function update(Tenant $tenant, array $data): Tenant
    {
        $tenant->update($this->getAttributes($data));

        return $tenant->fresh();
    }

    /**
     * @throws Throwable
     */
    public function delete(Tenant $tenant): void
    {
        $tenant->delete();
    }

    public function all(?int $limit = 20): Collection
    {
        return $this->getBuilder()->take($limit)->get();
    }

    private function getAttributes(array $data): array
    {
        return [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
        ];
    }

    public function getBuilder(): Builder
    {
        return Tenant::query();
    }
}
