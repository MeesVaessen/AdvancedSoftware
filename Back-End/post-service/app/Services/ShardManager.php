<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;

class ShardManager
{

    public function getConnectionName(string $userUuid): string
    {
        $connections = config('database.connections');
        $shardKeys = array_filter(array_keys($connections), function ($key) {
            return str_starts_with($key, 'shard_');
        });
        sort($shardKeys);

        $hash = hexdec(substr(hash('xxh128', $userUuid), 0, 15));

        $index = $hash % count($shardKeys);

        return $shardKeys[$index];
    }

}

