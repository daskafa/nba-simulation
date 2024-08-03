<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrepareSimulation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prepare-simulation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'All the necessary data for the simulation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $artisanCommands = [
            'migrate:fresh',
            'app:create-teams',
            'app:create-players',
            'app:create-fixture',
        ];

        foreach ($artisanCommands as $command) {
            $this->info("Running command: $command");
            $this->call($command);
            $this->line('');

            usleep(500000);
        }
    }
}
