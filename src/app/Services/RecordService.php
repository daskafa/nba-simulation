<?php

namespace App\Services;

use App\Interfaces\FixtureRepositoryInterface;
use App\Interfaces\PlayerStatRepositoryInterface;
use App\Interfaces\TeamStatRepositoryInterface;
use Illuminate\Support\Collection;

class RecordService
{
    public function __construct(
        private readonly TeamStatRepositoryInterface $teamStatRepository,
        private readonly PlayerStatRepositoryInterface $playerStatRepository,
        private readonly FixtureRepositoryInterface $fixtureRepository,
        private readonly PrepareDataService $prepareDataService
    ) {
        //
    }

    public function recordAllStats(Collection $teamStats, Collection $playerStats): void
    {
        $this->teamStatRepository->insert(
            $teamStats->toArray()
        );

        $this->playerStatRepository->insert(
            $playerStats->toArray()
        );
    }

    public function recordScores(): void
    {
        $aggregatedTeamStats = $this->teamStatRepository->getAggregatedTeamStats()->keyBy('team_id');
        $fixtures = $this->fixtureRepository->getAll();

        $this->fixtureRepository->upsert(
            $this->prepareDataService->mappingFixtureForScores($fixtures, $aggregatedTeamStats)->toArray(),
            ['id'],
            ['home_team_score', 'away_team_score']
        );

    }
}
