<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function incrementUpdateCount(): void
    {
        $updateCount = Cache::get('updateCount');

        Cache::put('updateCount', ! $updateCount ? 1 : $updateCount + 1, 60 * 24);
    }

    public function getUpdateCount(): int
    {
        return Cache::get('updateCount') ?? 0;
    }
}
