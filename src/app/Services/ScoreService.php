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

            [$randomPlayer, $assistedRandomPlayer] = $this->playerService->getRandomPlayers($team);

            $scores[] = [
                'player_id' => $randomPlayer->id,
                'assisted_player_id' => $score ? $assistedRandomPlayer->id : null,
                'score' => $score,
            ];
        }

        return $scores;
    }
}
