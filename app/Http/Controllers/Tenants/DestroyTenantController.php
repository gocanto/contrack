<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenants;

use App\Repository\TenantRepository;
use Illuminate\Http\JsonResponse;

final class DestroyTenantController
{
    private TenantRepository $tenants;

    public function __construct(TenantRepository $tenants)
    {
        $this->tenants = $tenants;
    }

    public function __invoke(string $uuid): JsonResponse
    {
        $tenant = $this->tenants->findByUuid($uuid);

        if ($tenant === null) {
            return new JsonResponse("The given tenant [{$uuid}] is invalid", JsonResponse::HTTP_NOT_FOUND);
        }

        $this->tenants->delete($tenant);

        return new JsonResponse();
    }
}
