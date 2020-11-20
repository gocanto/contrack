<?php

declare(strict_types=1);

use App\Http\Controllers\AllUnitsController;
use App\Http\Controllers\ShowUnitController;
use Illuminate\Support\Facades\Route;

Route::get('units', AllUnitsController::class);
Route::get('units/{uuid}', ShowUnitController::class);
