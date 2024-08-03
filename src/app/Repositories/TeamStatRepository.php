<?php

namespace App\Repositories;

use App\Interfaces\TeamStatRepositoryInterface;
use App\Models\TeamStat;
use Illuminate\Database\Eloquent\Builder;

class TeamStatRepository implements TeamStatRepositoryInterface
{
    public static function query(): Builder
    {
        return TeamStat::query();
    }

    public function insert(array $data): bool
    {
        return self::query()->insert($data);
    }
}
