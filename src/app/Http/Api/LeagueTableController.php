<?php

namespace App\Http\Api;

use App\Interfaces\TeamStatRepositoryInterface;
use Illuminate\Support\Collection;

class LeagueTableController
{
    public function __construct(
        private readonly TeamStatRepositoryInterface $teamStatRepository
    )
    {
        //
    }

    public function getLeagueTable(): Collection
    {
        return $this->teamStatRepository->getAggregatedTeamStats();
    }
}
