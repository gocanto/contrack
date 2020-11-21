<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenants;

use App\Http\Requests\TenantsRequest ;
use App\Repository\TenantRepository ;
use App\Transformer\TenantTransformer ;
use Illuminate\Http\JsonResponse;

final class StoreTenantController
{
    private TenantTransformer $transformer;
    private TenantRepository $tenants;

    public function __construct(TenantRepository $tenants, TenantTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->tenants = $tenants;
    }

    public function __invoke(TenantsRequest $request): JsonResponse
    {
        $tenant = $this->tenants->create($request->getData());

        $data = $this->transformer->transform($tenant);

        return new JsonResponse($data, JsonResponse::HTTP_CREATED);
    }
}
