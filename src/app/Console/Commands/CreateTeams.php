<?php

namespace App\Console\Commands;

use App\Models\Team;
use Illuminate\Console\Command;

class CreateTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates teams';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $teamsNames = [
            'Boston Celtics',
            'Brooklyn Nets',
            'New York Knicks',
            'Philadelphia 76ers',
            'Toronto Raptors',
            'Chicago Bulls',
            'Cleveland Cavaliers',
            'Detroit Pistons',
            'Indiana Pacers',
            'Milwaukee Bucks',
            'Atlanta Hawks',
            'Charlotte Hornets',
            'Miami Heat',
            'Orlando Magic',
            'Washington Wizards',
            'Los Angeles Lakers',
            'LA Clippers',
            'Golden State Warriors',
            'Phoenix Suns',
            'Sacramento Kings',
        ];

        Team::insert(
            array_map(fn($teamName) => ['name' => $teamName], $teamsNames)
        );

        $this->info('>>> Teams created successfully.');
    }
}
