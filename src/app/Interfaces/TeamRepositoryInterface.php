<?php

namespace App\Interfaces;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;

interface TeamRepositoryInterface
{
    public function create(array $data): Team|Model;
}
