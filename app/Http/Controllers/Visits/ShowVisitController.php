<?php

declare(strict_types=1);

namespace App\Http\Controllers\Visits;

use App\Repository\VisitRepository;
use App\Transformer\VisitTransformer;
use Illuminate\Http\JsonResponse;

final class ShowVisitController
{
    private VisitTransformer $transformer;
    private VisitRepository $visits;

    public function __construct(VisitRepository $visits, VisitTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->visits = $visits;
    }

    public function __invoke(string $uuid): JsonResponse
    {
        $visit = $this->visits->findByUuid($uuid);

        if ($visit === null) {
            return new JsonResponse("The given visit [{$uuid}] is invalid.", JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            $this->transformer->transform($visit),
            JsonResponse::HTTP_OK
        );
    }
}
