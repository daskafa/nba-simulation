<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class SimulationService
{
    public function __construct(
        private readonly AttackService $attackService,
        private readonly PrepareDataService $prepareDataService,
        private readonly RecordService $recordService
    )
    {
        //
    }

    public function simulate(Collection $fixtures)
    {
        $preparedData = $this->prepareDataService->prepareData(
            $this->attackService->distributeAttacksToTeamsWithScores($fixtures)
        );

        $this->recordService->recordAllStats(
            $this->prepareDataService->mappingForTeamStats($preparedData),
            $this->prepareDataService->mappingForPlayerStats($preparedData)
        );
    }
}
