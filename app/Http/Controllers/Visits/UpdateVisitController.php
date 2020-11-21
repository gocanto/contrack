<?php

declare(strict_types=1);

namespace App\Http\Controllers\Visits;

use App\Http\Requests\VisitsRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UpdateVisitController
{
    public function __invoke(VisitsRequest $request): JsonResponse
    {
        //ask for ic
        //update left time
    }
}
