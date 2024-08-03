<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;

class TeamRepository implements TeamRepositoryInterface
{
    public static function query(): Builder
    {
        return Team::query();
    }
}
