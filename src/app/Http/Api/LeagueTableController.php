<?php

namespace App\Http\Api;

use App\Interfaces\FixtureRepositoryInterface;
use App\Services\PrepareDataService;
use Illuminate\Support\Collection;

class LeagueTableController
{
    public function __construct(
        private readonly FixtureRepositoryInterface $fixtureRepository,
        private readonly PrepareDataService $prepareDataService
    ) {
        //
    }

    public function leagueTable(): Collection
    {
        return $this->prepareDataService->prepareLeagueTable(
            $this->fixtureRepository->getAll()->loadMissing('homeTeam', 'awayTeam')
        );
    }
}
