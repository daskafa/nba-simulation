<?php

use App\Http\Controllers\SimulationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SimulationController::class, 'simulation']);
Route::get('start-simulation', [SimulationController::class, 'startSimulation']);
