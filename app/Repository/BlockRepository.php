<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Block;
use App\Models\Condominium;
use Illuminate\Database\Eloquent\Builder;

class BlockRepository
{
    public function findBy(Condominium $condominium, string $uuid): ?Block
    {
        return $this->getBuilder()
            ->where('condominium_id', $condominium->id)
            ->where('uuid', $uuid)
            ->first();
    }

    public function findByUuid(string $uuid): ?Block
    {
        return $this->getBuilder()->where('uuid', $uuid)->first();
    }

    public function findByNumber(string $number): ?Block
    {
        return $this->getBuilder()->where('number', $number)->first();
    }

    private function getBuilder(): Builder
    {
        return Block::with('condominium', 'units');
    }
}
