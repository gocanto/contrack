<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Models\Block;

class BlockTransformer
{
    public function transform(Block $item): array
    {
        return [
            'uuid' => $item->uuid,
            'number' => $item->number,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
