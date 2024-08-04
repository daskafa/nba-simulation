<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\SimulationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FixtureController::class, 'fixture']);
Route::get('simulation', [SimulationController::class, 'simulation']);
Route::get('simulate', [SimulationController::class, 'simulate']);
