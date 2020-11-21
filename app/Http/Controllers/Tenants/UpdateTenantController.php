<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenants;

use App\Http\Requests\TenantsRequest;
use App\Repository\TenantRepository;
use App\Transformer\TenantTransformer;
use Illuminate\Http\JsonResponse;

final class UpdateTenantController
{
    private TenantTransformer $transformer;
    private TenantRepository $tenants;

    public function __construct(TenantRepository $tenants, TenantTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->tenants = $tenants;
    }

    public function __invoke(TenantsRequest $request, string $uuid): JsonResponse
    {
        $tenant = $this->tenants->findByUuid($uuid);

        if ($tenant === null) {
            return new JsonResponse("The given tenant [{$uuid}] is invalid", JsonResponse::HTTP_NOT_FOUND);
        }

        $tenant = $this->tenants->update($tenant, $request->getData());

        return new JsonResponse(
            $this->transformer->transform($tenant),
            JsonResponse::HTTP_OK
        );
    }
}
