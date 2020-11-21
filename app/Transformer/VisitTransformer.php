<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Models\Visit;
use Illuminate\Support\Collection;

class VisitTransformer
{
    public function transform(Visit $visit): array
    {
        return [
            'uuid' => $visit->uuid,
            'visitor_first_name' => $visit->visitor_first_name,
            'visitor_last_name' => $visit->visitor_last_name,
            'phone_number' => $visit->phone_number,
            'nric_last_r' => $visit->nric_last_r,
            'unit' => (new UnitTransformer())->transform($visit->unit),
            'arrived_at' => $visit->arrived_at,
            'left_at' => $visit->left_at,
            'created_at' => $visit->created_at,
            'updated_at' => $visit->updated_at,
        ];
    }

    public function collection(Collection $units): Collection
    {
        return $units->map(fn (Visit $visit) => $this->transform($visit));
    }
}
