<?php

declare(strict_types=1);

namespace App\Http\Controllers\Units;

use App\Repository\TenantRepository;
use App\Repository\UnitRepository;
use App\Transformer\UnitTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

final class ManageUnitController
{
    private TenantRepository $tenants;
    private UnitRepository $units;
    private UnitTransformer $transformer;

    public function __construct(UnitRepository $units, TenantRepository $tenants, UnitTransformer $transformer)
    {
        $this->tenants = $tenants;
        $this->units = $units;
        $this->transformer = $transformer;
    }

    public function markAsRented(Request $request, string $uuid): JsonResponse
    {
        try {
            [$unit, $tenant] = $this->getUnitAndTenant($uuid, $request->input('tenant_uuid'));
        } catch (RuntimeException $exception) {
            return new JsonResponse($exception->getMessage(), JsonResponse::HTTP_NOT_FOUND);
        }

        $unit = $this->units->markAsRented($unit, $tenant);

        return new JsonResponse(
            $this->transformer->transform($unit),
            JsonResponse::HTTP_OK
        );
    }

    public function markAsAvailable(string $uuid): JsonResponse
    {
        $unit = $this->units->findByUuid($uuid);

        if ($unit === null) {
            return new JsonResponse("The given unit [{$uuid}] is invalid.", JsonResponse::HTTP_NOT_FOUND);
        }

        $unit = $this->units->markAsAvailable($unit);

        return new JsonResponse(
            $this->transformer->transform($unit),
            JsonResponse::HTTP_OK
        );
    }

    private function getUnitAndTenant(string $unitUuid, ?string $tenantUuid): array
    {
        $unit = $this->units->findByUuid($unitUuid);

        if ($unit === null || $unit->isRented()) {
            throw new RuntimeException("The given unit [{$unitUuid}] is invalid or already occupied.");
        }

        $tenant = $this->tenants->findByUuid($tenantUuid ?? '');

        if ($tenant === null) {
            throw new RuntimeException('The given tenant [' . ($tenantUuid ?? 'empty') . '] is invalid.');
        }

        return [$unit, $tenant];
    }
}
