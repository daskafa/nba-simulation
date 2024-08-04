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

    public function leagueTable(): Collection
    {
        return $this->teamStatRepository->getAggregatedTeamStatsWithTeam()
            ->sortByDesc('total_score')->values();
    }
}
