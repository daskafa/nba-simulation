<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class AttackService
{
    private const MIN_DURATION = 7;

    private const MAX_DURATION = 24;

    private const TOTAL_TIME = 60;

    public function __construct(
        private readonly ScoreService $scoreService
    ) {
        //
    }

    public function generatedAttacksCount(): int
    {
        $intervals = [];
        $totalTime = self::TOTAL_TIME;

        while ($totalTime > 0) {
            $interval = $this->generateInterval($totalTime);
            $intervals[] = $interval;
            $totalTime -= $interval;
        }

        return count($intervals);
    }

    private function generateInterval(int $totalTime): int
    {
        return min(rand(self::MIN_DURATION, self::MAX_DURATION), $totalTime);
    }

    public function distributeAttacksToTeamsWithScores(Collection $fixtures): array
    {
        for($i = 0; $i < count($fixtures); $i++) {
            $homeTeam = $fixtures[$i]->homeTeam;
            $awayTeam = $fixtures[$i]->awayTeam;

            [$homeTeamAttacks, $awayTeamAttacks] = $this->teamAttacks();

            $results[] = [
                $homeTeam->id => $this->scoreService->determineScores($homeTeamAttacks, $homeTeam),
                $awayTeam->id => $this->scoreService->determineScores($awayTeamAttacks, $awayTeam),
            ];
        }

        return $results;
    }

    public function teamAttacks(): array
    {
        $homeTeamAttacks = [];
        $awayTeamAttacks = [];

        for ($j = 0; $j < $this->generatedAttacksCount(); $j++) {
            if (rand(0, 1) === 0) {
                $homeTeamAttacks[] = true;
            } else {
                $awayTeamAttacks[] = true;
            }
        }

        return array($homeTeamAttacks, $awayTeamAttacks);
    }
}
