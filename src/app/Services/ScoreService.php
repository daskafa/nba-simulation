<?php

namespace App\Services;

use App\Models\Team;

class ScoreService
{
    public function __construct(
        private readonly PlayerService $playerService
    )
    {
        //
    }

    public function determineScores(array $teamAttacks, Team $team): array {
        $scores = [];

        for($i = 0; $i < count($teamAttacks); $i++) {
            match (rand(0, 3)) {
                2 => $score = 2,
                3 => $score = 3,
                default => $score = 0,
            };

            if ($score){
                [$scorerRandomPlayer, $assistedRandomPlayer] = $this->playerService->getRandomPlayers($team);
            }

            $scores[] = [
                'scorer_player' => $score ? $scorerRandomPlayer->name : null,
                'assisted_player' => $score ? $assistedRandomPlayer->name : null,
                'score' => $score,
            ];
        }

        return $scores;
    }
}
