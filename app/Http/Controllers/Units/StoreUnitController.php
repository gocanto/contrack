<?php

declare(strict_types=1);

namespace App\Http\Controllers\Units;

use App\Http\Requests\UnitsRequest;
use App\Repository\UnitRepository;
use App\Transformer\UnitTransformer;
use Illuminate\Http\JsonResponse;

final class StoreUnitController
{
    private UnitTransformer $transformer;
    private UnitRepository $units;

    public function __construct(UnitRepository $units, UnitTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->units = $units;
    }

    public function __invoke(UnitsRequest $request): JsonResponse
    {
        $unit = $this->units->create($request->getData());

        $data = $this->transformer->transform($unit);

        return new JsonResponse($data, JsonResponse::HTTP_CREATED);
    }
}
