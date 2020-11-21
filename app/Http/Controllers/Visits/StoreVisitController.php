<?php

declare(strict_types=1);

namespace App\Http\Controllers\Visits;

use App\Http\Requests\VisitsRequest;
use App\Repository\VisitRepository;
use App\Transformer\VisitTransformer;
use Illuminate\Http\JsonResponse;

final class StoreVisitController
{
    private VisitRepository $visits;
    private VisitTransformer $transformer;

    public function __construct(VisitRepository $visits, VisitTransformer $transformer)
    {
        $this->visits = $visits;
        $this->transformer = $transformer;
    }

    public function __invoke(VisitsRequest $request): JsonResponse
    {
        $unit = $request->getUnit();

        if ($unit->getCurrentVisitors()->count() > 5) {
            return new JsonResponse(
                'The given unit [' . $unit->number . '] has reached its max capacity.',
                JsonResponse::HTTP_FORBIDDEN
            );
        }

//        dd('here', $request->getBlock()->units->where('id', $unit->id)->first());

        $visit = $this->visits->create($request->getBlock(), $unit, $request->getData());

        return new JsonResponse(
            $this->transformer->transform($visit),
            JsonResponse::HTTP_CREATED
        );
    }
}
