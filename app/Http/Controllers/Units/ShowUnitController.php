<?php

declare(strict_types=1);

namespace App\Http\Controllers\Units;

use App\Repository\UnitRepository;
use App\Transformer\UnitTransformer;
use Illuminate\Http\JsonResponse;

final class ShowUnitController
{
    private UnitTransformer $transformer;
    private UnitRepository $units;

    public function __construct(UnitRepository $units, UnitTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->units = $units;
    }

    public function __invoke(string $uuid): JsonResponse
    {
        $unit = $this->units->findByUuid($uuid);

        if ($unit === null) {
            return new JsonResponse("The given unit [{$uuid}] is invalid", JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            $this->transformer->transformWithVisits($unit),
            JsonResponse::HTTP_OK
        );
    }
}
