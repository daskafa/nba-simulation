<?php

namespace App\Services;

use App\Interfaces\PlayerStatRepositoryInterface;
use App\Interfaces\TeamStatRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SimulationService
{
    public function __construct(
        private readonly AttackService $attackService,
        private readonly PrepareDataService $prepareDataService,
        private readonly RecordService $recordService,
        private readonly TeamStatRepositoryInterface $teamStatRepository,
        private readonly PlayerStatRepositoryInterface $playerStatRepository
    ) {
        //
    }

    public function simulate(Collection $fixtures): array
    {
        $preparedData = $this->prepareDataService->prepareData(
            $this->attackService->distributeAttacksToTeamsWithScores($fixtures)
        );

        $this->recordService->recordAllStats(
            $this->prepareDataService->mappingForTeamStats($preparedData),
            $this->prepareDataService->mappingForPlayerStats($preparedData)
        );

        $simulationData = $this->prepareDataService->prepareSimulationData(
            $preparedData, $this->teamStatRepository->getAggregatedTeamStats()
        );

        $playerStats = $this->playerStatRepository->getTotalAssists()->toArray();

        $successRates = $this->prepareDataService->prepareSuccessRates(
            $this->playerStatRepository->getSuccessRates()
        );

        return [
            'simulationData' => $simulationData,
            'playerStats' => $playerStats,
            'successRates' => $successRates,
        ];
    }
}
