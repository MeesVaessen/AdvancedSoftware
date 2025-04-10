<?php

namespace App\Services;

class ShardManager
{
    public function getConnectionName(string $userUuid): string
    {
        $shards = config('sharding.connections');

        $hash = crc32($userUuid);
        $index = $hash % count($shards);

        return $shards[$index];
    }
}
