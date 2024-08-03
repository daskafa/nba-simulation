<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CreateFixture extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-fixture';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a fixture for the first week';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $teams = Team::all();

        $fixtures = $this->generateFixtures($teams);

        Fixture::insert($fixtures);

        $this->info('First week fixtures created successfully');
    }

    private function generateFixtures(Collection $teams): array
    {
        $fixtures = [];
        $shuffledTeams = $teams->shuffle();

        for ($i = 0; $i < 10; $i++) {
            $homeTeam = $shuffledTeams[$i];
            $awayTeam = $shuffledTeams[19 - $i];
            $fixtures[] = [
                'home_team_id' => $homeTeam->id,
                'away_team_id' => $awayTeam->id,
            ];
        }

        return $fixtures;
    }
}
