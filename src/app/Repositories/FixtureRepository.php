<?php

namespace App\Repositories;

use App\Interfaces\FixtureRepositoryInterface;
use App\Models\Fixture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class FixtureRepository implements FixtureRepositoryInterface
{
    public static function query(): Builder
    {
        return Fixture::query();
    }

    public function getAll(): Collection
    {
        return self::query()->get();
    }

    public function upsert(array $data, array $uniqueBy, array $update): void
    {
        Fixture::upsert($data, $uniqueBy, $update);
    }
}
