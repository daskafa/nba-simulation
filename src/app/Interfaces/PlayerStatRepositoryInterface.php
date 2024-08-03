<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface PlayerStatRepositoryInterface
{
    public static function query(): Builder;

    public function insert(array $data): bool;
}
