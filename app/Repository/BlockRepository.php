<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Block;
use Illuminate\Database\Eloquent\Builder;

class BlockRepository
{
    public function findByUuid(string $uuid): ?Block
    {
        return $this->getBuilder()->where('uuid', $uuid)->first();
    }

    public function findByNumber(string $number): ?Block
    {
        return $this->getBuilder()->where('number', $number)->first();
    }

    public function getBuilder(): Builder
    {
        return Block::query();
    }
}
