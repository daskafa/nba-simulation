<?php

namespace App\Http\Controllers;

use App\Interfaces\FixtureRepositoryInterface;
use App\Services\CacheService;
use App\Services\SimulationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SimulationController extends Controller
{
    private const MAX_UPDATE_COUNT = 3;

    public function __construct(
        private readonly FixtureRepositoryInterface $fixtureRepository,
        private readonly SimulationService $simulationService,
        private readonly CacheService $cacheService
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

    public function simulate(): JsonResponse
    {
        try {
            if ($this->cacheService->getUpdateCount() === self::MAX_UPDATE_COUNT) {
                return response()->json([
                    'message' => 'Simulation is over.'
                ]);
            }

            DB::beginTransaction();

            $simulationData = $this->simulationService->simulate(
                $this->fixtureRepository->getAll()->loadMissing('homeTeam.players', 'awayTeam.players'),
            );

            $this->cacheService->incrementUpdateCount();

            DB::commit();

            return response()->json([
                'simulationData' => $simulationData['simulationData'],
                'playerStats' => $simulationData['playerStats'],
                'successRates' => $simulationData['successRates'],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
