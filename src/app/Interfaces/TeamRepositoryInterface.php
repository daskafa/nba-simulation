<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface TeamRepositoryInterface
{
    public static function query(): Builder;
}
