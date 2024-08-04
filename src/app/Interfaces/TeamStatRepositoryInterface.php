<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface TeamStatRepositoryInterface
{
    public static function query(): Builder;

    public function insert(array $data): bool;

    public function getAggregatedTeamStats(): Collection;
}
