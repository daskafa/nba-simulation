<?php

use App\Http\Api\LeagueTableController;
use Illuminate\Support\Facades\Route;

Route::get('league-table', [LeagueTableController::class, 'getLeagueTable']);
