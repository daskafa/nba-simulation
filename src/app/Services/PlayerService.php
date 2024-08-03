<?php

namespace App\Services;

use App\Models\Player;
use App\Models\Team;

class PlayerService
{
    public function getRandomPlayers(Team $team): array
    {
        $scorerRandomPlayer = $this->getRandomPlayer($team);
        $assistedRandomPlayer = $this->getRandomPlayer($team);

        if ($scorerRandomPlayer->id === $assistedRandomPlayer->id) {
            return $this->getRandomPlayers($team);
        }

        return [$scorerRandomPlayer, $assistedRandomPlayer];
    }

    public function getRandomPlayer(Team $team): Player {
        return $team->players->random();
    }
}
