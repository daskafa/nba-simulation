<?php

namespace App\Http\Controllers;

use App\Interfaces\FixtureRepositoryInterface;
use Illuminate\View\View;

class FixtureController
{
    public function __construct(
        private readonly FixtureRepositoryInterface $fixtureRepository,
    ) {
        //
    }

    public function fixture(): View
    {
        return view('fixture', [
            'fixture' => $this->fixtureRepository->getAll()->loadMissing('homeTeam', 'awayTeam'),
        ]);
    }
}
