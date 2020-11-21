<?php

declare(strict_types=1);

namespace App\Http\Controllers\Units;

use App\Http\Requests\UnitsRequest;
use App\Repository\UnitRepository;
use App\Transformer\UnitTransformer;
use Illuminate\Http\JsonResponse;

final class UpdateUnitController
{
    private UnitTransformer $transformer;
    private UnitRepository $units;

    public function __construct(UnitRepository $units, UnitTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->units = $units;
    }

    public function __invoke(UnitsRequest $request, string $uuid): JsonResponse
    {
        $unit = $this->units->findByUuid($uuid);

        if ($unit === null) {
            return new JsonResponse("The given unit [{$uuid}] is invalid", JsonResponse::HTTP_NOT_FOUND);
        }

        $unit = $this->units->update($unit, $request->getData());

        return new JsonResponse(
            $this->transformer->transform($unit),
            JsonResponse::HTTP_OK
        );
    }
}
