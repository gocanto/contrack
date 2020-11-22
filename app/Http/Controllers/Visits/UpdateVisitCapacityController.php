<?php

declare(strict_types=1);

namespace App\Http\Controllers\Visits;

use App\Repository\VisitRepository;
use App\Transformer\VisitTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UpdateVisitCapacityController
{
    private VisitRepository $visits;
    private VisitTransformer $transformer;

    public function __construct(VisitRepository $visits, VisitTransformer $transformer)
    {
        $this->visits = $visits;
        $this->transformer = $transformer;
    }

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $visit = $this->visits->findByNricAndUuid(
            $request->input('nric_last_four', ''),
            $uuid
        );

        if ($visit === null) {
            return new JsonResponse('The the given nric number is invalid.', JsonResponse::HTTP_NOT_FOUND);
        }

        $visit = $this->visits->updateCapacity($visit);

        return new JsonResponse(
            $this->transformer->transform($visit),
            JsonResponse::HTTP_OK
        );
    }
}
