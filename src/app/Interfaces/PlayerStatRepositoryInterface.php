<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface PlayerStatRepositoryInterface
{
    public static function query(): Builder;

    public function insert(array $data): bool;

    public function getTotalAssists(): Collection;

    public function getSuccessRates(): Collection;
}
