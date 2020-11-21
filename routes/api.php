<?php

declare(strict_types=1);

use App\Http\Controllers\Units;
use App\Http\Controllers\Tenants;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

// --- Units
Route::get('units', Units\AllUnitsController::class);
Route::post('units', Units\StoreUnitController::class);
Route::get('units/{uuid}', Units\ShowUnitController::class);
Route::put('units/{uuid}', Units\UpdateUnitController::class);
Route::delete('units/{uuid}', Units\DestroyUnitController::class);

// --- Rent Units
Route::group(['prefix' => 'manage-unit'], static function (Router $router) {
    $router->post('mark-as-rented/{uuid}', [Units\ManageUnitController::class, 'markAsRented']);
    $router->post('mark-as-available/{uuid}', [Units\ManageUnitController::class, 'markAsAvailable']);
});

// --- Tenants
Route::get('tenants', Tenants\AllTenantsController::class);
Route::post('tenants', Tenants\StoreTenantController::class);
Route::get('tenants/{uuid}', Tenants\ShowTenantController::class);
Route::put('tenants/{uuid}', Tenants\UpdateTenantController::class);
Route::delete('tenants/{uuid}', Tenants\DestroyTenantController::class);
