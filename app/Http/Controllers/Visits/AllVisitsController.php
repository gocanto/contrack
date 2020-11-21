<?php

declare(strict_types=1);

namespace App\Http\Controllers\Visits;

use App\Repository\VisitRepository;
use App\Transformer\VisitTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class AllVisitsController
{
    private VisitRepository $visits;
    private VisitTransformer $transformer;

    public function __construct(VisitRepository $visits, VisitTransformer $transformer)
    {
        $this->visits = $visits;
        $this->transformer = $transformer;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $visits = $this->transformer->collection(
            $this->visits->all([
                'phone_number' => $request->input('phone_number'),
                'limit' => $request->input('limit'),
            ])
        );

        return new JsonResponse(
            new LengthAwarePaginator($visits, $visits->count(), 100),
            JsonResponse::HTTP_OK
        );
    }
}
