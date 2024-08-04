<?php

namespace App\Repositories;

use App\Interfaces\TeamStatRepositoryInterface;
use App\Models\TeamStat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

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

    public function getAggregatedTeamStats(): Collection
    {
        return self::query()
            ->select('team_id', DB::raw('SUM(score) as score'), DB::raw('SUM(attack_count) as total_attack_count'))
            ->groupBy('team_id')
            ->get()
            ->keyBy('team_id');
    }
}
