<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Models\Tenant;
use Illuminate\Support\Collection;

class TenantTransformer
{
    public function transform(Tenant $item): array
    {
        return [
            'uuid' => $item->uuid,
            'first_name' => $item->first_name,
            'last_name' => $item->last_name,
            'phone_number' => $item->phone_number,
            'created_at' => $item->created_at,
            'updated_at' => $item->updated_at,
        ];
    }

    public function collection(Collection $units): Collection
    {
        return $units->map(fn (Tenant $tenant) => $this->transform($tenant));
    }
}
