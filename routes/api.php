<?php

declare(strict_types=1);

use App\Http\Controllers\AllUnitsController;
use App\Http\Controllers\CreateUnitController;
use App\Http\Controllers\ShowUnitController;
use App\Http\Controllers\UpdateUnitController;
use Illuminate\Support\Facades\Route;

Route::get('units', AllUnitsController::class);
Route::get('units/create', CreateUnitController::class);
Route::get('units/{uuid}', ShowUnitController::class);
Route::put('units/{uuid}', UpdateUnitController::class);
