<?php

declare(strict_types=1);

use App\Http\Controllers\AllUnitsController;
use Illuminate\Support\Facades\Route;

Route::get('units', AllUnitsController::class);
