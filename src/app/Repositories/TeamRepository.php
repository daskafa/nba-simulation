<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TeamRepository implements TeamRepositoryInterface
{
    public static function query(): Builder
    {
        return Team::query();
    }

    public function create(array $data): Team|Model
    {
        return self::query()->create($data);
    }
}
