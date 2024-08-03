<?php

namespace App\Interfaces;

use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface TeamRepositoryInterface
{
    public static function query(): Builder;

    public function create(array $data): Team|Model;
}
