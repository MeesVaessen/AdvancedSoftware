<?php

namespace App\Repositories;

use App\Repositories\Interfaces\postLookupRepositoryInterface;
use Illuminate\Support\Facades\DB;

class postLookupRepository implements postLookupRepositoryInterface
{

    public function createLookup($postId, $shard): void
    {
        DB::connection('central')->table('post_shard_lookup')->insert([
            'post_id' => $postId,
            'shard' => $shard,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function getLookup($id)
    {
        return DB::connection('central')
            ->table('post_shard_lookup')
            ->where('post_id', $id)
            ->first();
    }
}
