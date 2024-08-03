<?php

namespace App\Services;

use App\Interfaces\PlayerStatRepositoryInterface;
use App\Interfaces\TeamStatRepositoryInterface;

class RecordService
{
    public function __construct(
        private readonly TeamStatRepositoryInterface $teamStatRepository,
        private readonly PlayerStatRepositoryInterface $playerStatRepository
    )
    {
        //
    }

    public function recordAllStats(array $teamStats, array $playerStats): void
    {
        $this->teamStatRepository->insert($teamStats);
        $this->playerStatRepository->insert($playerStats);
    }
}
