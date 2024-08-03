<?php

namespace App\Http\Controllers;

use App\Interfaces\FixtureRepositoryInterface;
use App\Services\SimulationService;
use Illuminate\View\View;

class SimulationController extends Controller
{
    public function __construct(
        private readonly FixtureRepositoryInterface $fixtureRepository,
        private readonly SimulationService $simulationService
    )
    {
        //
    }

    public function fixture(): View
    {
        return view('fixture', [
            'fixture' => $this->fixtureRepository->getAll()->loadMissing('homeTeam', 'awayTeam'),
        ]);
    }

    public function simulation(): View
    {

        return view('simulation', [
            'fixture' => $this->fixtureRepository->getAll()->loadMissing('homeTeam.players', 'awayTeam.players'),
        ]);
    }

    public function simulate()
    {
        return response()->json([
            'message' => 'Simulation completed',
        ]);
    }
}
