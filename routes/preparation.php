<?php

declare(strict_types=1);

use App\Http\Controllers\PreparationChecklistController;
use Illuminate\Support\Facades\Route;

Route::get('/persiapan-glamping', PreparationChecklistController::class)
    ->name('preparation.checklist');
