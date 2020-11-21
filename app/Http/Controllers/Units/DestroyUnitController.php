<?php

declare(strict_types=1);

namespace App\Http\Controllers\Units;

use App\Repository\UnitRepository;
use Illuminate\Http\JsonResponse;

final class DestroyUnitController
{
    private UnitRepository $units;

    public function __construct(UnitRepository $units)
    {
        $this->units = $units;
    }

    public function __invoke(string $uuid): JsonResponse
    {
        $unit = $this->units->findByUuid($uuid);

        if ($unit === null) {
            return new JsonResponse("The given unit [{$uuid}] is invalid", JsonResponse::HTTP_NOT_FOUND);
        }

        $this->units->delete($unit);

        return new JsonResponse();
    }
}
