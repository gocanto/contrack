<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Models\Unit;
use Illuminate\Support\Collection;

class UnitTransformer
{
    private CondominiumTransformer $condominium;
    private BlockTransformer $block;
    private TenantTransformer $tenant;

    public function __construct(CondominiumTransformer $condominium, BlockTransformer $block, TenantTransformer $tenant)
    {
        $this->condominium = $condominium;
        $this->block = $block;
        $this->tenant = $tenant;
    }

    public function transform(Unit $unit): array
    {
        return [
            'uuid' => $unit->uuid,
            'number' => $unit->number,
            'created_at' => $unit->created_at,
            'updated_at' => $unit->updated_at,
            'condominium' => $this->condominium->transform($unit->condominium),
            'block' => $this->block->transform($unit->block),
            'tenant' => $unit->isRented() ? $this->tenant->transform($unit->tenant) : [],
        ];
    }

    public function collection(Collection $units): Collection
    {
        return $units->map(fn (Unit $unit) => $this->transform($unit));
    }
}
