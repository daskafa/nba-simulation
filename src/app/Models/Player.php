<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'power',
    ];
}
