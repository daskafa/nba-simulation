<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface PlayerRepositoryInterface
{
    public static function query(): Builder;
}
