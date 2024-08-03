<?php

namespace App\Console\Commands;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Console\Command;

class CreatePlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-players';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates players';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $preparedPlayers = [];
        foreach (Team::all() as $team) {
            $preparedPlayers = $this->preparePlayers($this->getPlayers(), $team, $preparedPlayers);
        }

        Player::insert($preparedPlayers);

        $this->info('>>> Players created successfully.');
    }

    private function getPlayers(): array
    {
        return [
            ['name' => fake()->name, 'power' => random_int(1, 10)],
            ['name' => fake()->name, 'power' => random_int(1, 10)],
            ['name' => fake()->name, 'power' => random_int(1, 10)],
            ['name' => fake()->name, 'power' => random_int(1, 10)],
            ['name' => fake()->name, 'power' => random_int(1, 10)],
        ];
    }

    private function preparePlayers(array $players, Team $team, array $preparedPlayers): array
    {
        foreach ($players as $player) {
            $player['team_id'] = $team->id;
            $preparedPlayers[] = $player;
        }

        return $preparedPlayers;
    }
}
