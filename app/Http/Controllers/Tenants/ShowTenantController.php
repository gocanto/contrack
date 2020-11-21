<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenants;

use App\Repository\TenantRepository;
use App\Transformer\TenantTransformer;
use Illuminate\Http\JsonResponse;

final class ShowTenantController
{
    private TenantTransformer $transformer;
    private TenantRepository $tenants;

    public function __construct(TenantRepository $tenant, TenantTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->tenants = $tenant;
    }

    public function __invoke(string $uuid): JsonResponse
    {
        $tenant = $this->tenants->findByUuid($uuid);

        if ($tenant === null) {
            return new JsonResponse("The given tenant [{$uuid}] is invalid", JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            $this->transformer->transform($tenant),
            JsonResponse::HTTP_OK
        );
    }
}
