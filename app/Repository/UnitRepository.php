<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Unit;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UnitRepository
{
    private CondominiumRepository $condominium;
    private BlockRepository $block;
    private TenantRepository $tenant;

    public function __construct(CondominiumRepository $condominium, BlockRepository $block, TenantRepository $tenant)
    {
        $this->condominium = $condominium;
        $this->block = $block;
        $this->tenant = $tenant;
    }

    public function create(array $data): Unit
    {
        return Unit::create($this->getAttributes($data));
    }

    public function update(Unit $unit, array $data): Unit
    {
        $unit->update($this->getAttributes($data));

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

    private function getAttributes(array $data): array
    {
        $condominium = $this->condominium->findByUuid($data['condominium_uuid']);
        $block = $this->block->findByUuid($data['block_uuid']);

        $tenant = isset($data['tenant_uuid'])
            ? $this->tenant->findByUuid($data['tenant_uuid'])
            : null;

        return [
            'block_id' => $block->id,
            'number' => $data['number'],
            'condominium_id' => $condominium->id,
            'tenant_id' => $tenant ? $tenant->id : null,
        ];
    }
}
