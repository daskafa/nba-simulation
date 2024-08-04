<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface FixtureRepositoryInterface
{
    public static function query(): Builder;

    public function getAll(): Collection;

    public function upsert(array $data, array $uniqueBy, array $update): void;
}
