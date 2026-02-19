<?php

use App\Http\Controllers\Api\CalculationController;
use Illuminate\Support\Facades\Route;

Route::resource('calculations', CalculationController::class)->only(['index', 'store', 'destroy']);
Route::delete('/calculations', [CalculationController::class, 'clear']);
