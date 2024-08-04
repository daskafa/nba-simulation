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
            ->select('team_id', DB::raw('SUM(total_score) as total_score'), DB::raw('SUM(attack_count) as total_attack_count'))
            ->groupBy('team_id')
            ->get()
            ->keyBy('team_id');
    }

    public function getAggregatedTeamStatsWithTeam(): Collection
    {
        return self::query()
            ->select('team_id', DB::raw('SUM(total_score) as total_score'), DB::raw('SUM(attack_count) as total_attack_count'))
            ->with('team')
            ->groupBy('team_id')
            ->get()
            ->keyBy('team_id');
    }
}
