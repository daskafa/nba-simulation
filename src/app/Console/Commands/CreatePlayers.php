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
        $teams = Team::all();

        $playersArray = [];
        foreach ($teams as $team) {
            $players = [
                ['name' => fake()->name, 'power' => random_int(1, 10)],
                ['name' => fake()->name, 'power' => random_int(1, 10)],
                ['name' => fake()->name, 'power' => random_int(1, 10)],
                ['name' => fake()->name, 'power' => random_int(1, 10)],
                ['name' => fake()->name, 'power' => random_int(1, 10)],
            ];

            foreach ($players as $player) {
                $player['team_id'] = $team->id;
                $playersArray[] = $player;
            }
        }

        Player::insert($playersArray);

        $this->info('Players created successfully');
    }
}
