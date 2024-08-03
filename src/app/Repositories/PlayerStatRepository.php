<?php

namespace App\Repositories;

use App\Interfaces\PlayerStatRepositoryInterface;
use App\Models\PlayerStat;
use Illuminate\Database\Eloquent\Builder;

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
}
