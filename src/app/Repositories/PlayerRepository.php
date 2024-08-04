<?php

namespace App\Repositories;

use App\Interfaces\PlayerRepositoryInterface;
use App\Models\Player;
use Illuminate\Database\Eloquent\Builder;

class PlayerRepository implements PlayerRepositoryInterface
{
    public static function query(): Builder
    {
        return Player::query();
    }
}
