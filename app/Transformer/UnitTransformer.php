<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Models\Unit;
use Illuminate\Support\Collection;

class UnitTransformer
{
    public function transform(Unit $unit): array
    {
        return [
            'uuid' => $unit->uuid,
            'number' => $unit->number,
            'created_at' => $unit->created_at,
            'updated_at' => $unit->updated_at,
            'condominium' => (new CondominiumTransformer())->transform($unit->condominium),
            'block' => (new BlockTransformer())->transform($unit->block),
            'tenant' => $unit->isRented() ? (new TenantTransformer())->transform($unit->tenant) : [],
        ];
    }

    public function transformWithVisits(Unit $unit): array
    {
        return array_merge($this->transform($unit), [
            'visits' => (new VisitTransformer())->collection($unit->visits),
        ]);
    }

    public function collection(Collection $units): Collection
    {
        return $units->map(fn (Unit $unit) => $this->transform($unit));
    }
}
