<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface TeamStatRepositoryInterface
{
    public static function query(): Builder;

    public function insert(array $data): bool;
}
