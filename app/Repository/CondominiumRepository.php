<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Block;
use App\Models\Condominium;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Builder;

class CondominiumRepository
{
    private BlockRepository $blocks;
    private UnitRepository $units;

    public function __construct(BlockRepository $blocks, UnitRepository $units)
    {
        $this->blocks = $blocks;
        $this->units = $units;
    }

    public function findByUuid(string $uuid): ?Condominium
    {
        return $this->getBuilder()->where('uuid', $uuid)->first();
    }

    public function findBlockBy(Condominium $condominium, string $uuid): ?Block
    {
        return $this->blocks->findBy($condominium, $uuid);
    }

    public function findUnitBy(Condominium $condominium, Block $block, string $uuid): ?Unit
    {
        return $this->units->findBy($condominium, $block, $uuid);
    }

    private function getBuilder(): Builder
    {
        return Condominium::with('blocks');
    }
}
