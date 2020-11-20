<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Models\Condominium;

class CondominiumTransformer
{
    public function transform(Condominium $item): array
    {
        return [
            'uuid' => $item->uuid,
            'name' => $item->name,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }
}
