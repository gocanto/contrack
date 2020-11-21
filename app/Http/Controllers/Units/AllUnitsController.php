<?php

declare(strict_types=1);

namespace App\Http\Controllers\Units;

use App\Repository\UnitRepository;
use App\Transformer\UnitTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class AllUnitsController
{
    private UnitTransformer $transformer;
    private UnitRepository $units;

    public function __construct(UnitRepository $units, UnitTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->units = $units;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $units = $this->transformer->collection(
            $this->units->all($request->input('limit'))
        );

        return new JsonResponse(
            new LengthAwarePaginator($units, $units->count(), 50),
            JsonResponse::HTTP_OK
        );
    }
}
