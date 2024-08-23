<?php

use App\Http\Controllers\CalculateController;
use Illuminate\Support\Facades\Route;

Route::middleware('apiKey:calculate')
    ->as('api.v1')
    ->prefix('v1')
    ->group(function () {
        Route::post('calculate', CalculateController::class)->name('.calculate');
    });
