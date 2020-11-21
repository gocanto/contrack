<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenants;

use App\Repository\TenantRepository;
use App\Transformer\TenantTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class AllTenantsController
{
    private TenantTransformer $transformer;
    private TenantRepository $tenants;

    public function __construct(TenantRepository $tenants, TenantTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->tenants = $tenants;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $units = $this->transformer->collection(
            $this->tenants->all($request->input('limit'))
        );

        return new JsonResponse(
            new LengthAwarePaginator($units, $units->count(), 50),
            JsonResponse::HTTP_OK
        );
    }
}
