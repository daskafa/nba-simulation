<?php

namespace App\Services;

use App\Interfaces\PlayerStatRepositoryInterface;
use App\Interfaces\TeamStatRepositoryInterface;
use Illuminate\Support\Collection;

class RecordService
{
    public function __construct(
        private readonly TeamStatRepositoryInterface $teamStatRepository,
        private readonly PlayerStatRepositoryInterface $playerStatRepository
    )
    {
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
}
