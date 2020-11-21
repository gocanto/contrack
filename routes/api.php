<?php

declare(strict_types=1);

use App\Http\Controllers\Units;
use Illuminate\Support\Facades\Route;

Route::get('units', Units\AllUnitsController::class);
Route::get('units/create', Units\CreateUnitController::class);
Route::get('units/{uuid}', Units\ShowUnitController::class);
Route::put('units/{uuid}', Units\UpdateUnitController::class);
Route::delete('units/{uuid}', Units\DestroyUnitController::class);
