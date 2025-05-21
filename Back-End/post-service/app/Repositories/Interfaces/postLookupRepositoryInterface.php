<?php

namespace App\Repositories\Interfaces;

interface postLookupRepositoryInterface
{
public function createLookup($postId, $shard);

public function getLookup($id);
}
