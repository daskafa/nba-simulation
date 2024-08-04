<?php

namespace App\Repositories;

use App\Interfaces\PlayerStatRepositoryInterface;
use App\Models\PlayerStat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PlayerStatRepository implements PlayerStatRepositoryInterface
{
    public static function query(): Builder
    {
        return PlayerStat::query();
    }

    public function insert(array $data): bool
    {
        return self::query()->insert($data);
    }

    public function getTotalAssists(): Collection
    {
        return self::query()->select('assisted_player_id')
            ->whereNotNull('assisted_player_id')
            ->groupBy('assisted_player_id')
            ->selectRaw('assisted_player_id, COUNT(*) as total_assists')
            ->get();
    }

    public function getSuccessRates(): Collection
    {
        return self::query()
            ->select(
                'player_id',
                DB::raw('SUM(CASE WHEN score = 2 THEN 1 ELSE 0 END) as score_2_count'),
                DB::raw('SUM(CASE WHEN score = 3 THEN 1 ELSE 0 END) as score_3_count'),
                DB::raw('COUNT(*) as total_attempts')
            )
            ->groupBy('player_id')
            ->get();
    }
}
