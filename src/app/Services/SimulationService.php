<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class SimulationService
{
    public function __construct(private readonly AttackService $attackService)
    {
        //
    }

    public function simulate(Collection $fixtures)
    {
        $distributeAttacksToTeams = $this->attackService->distributeAttacksToTeamsWithScores($fixtures);
    }
}
