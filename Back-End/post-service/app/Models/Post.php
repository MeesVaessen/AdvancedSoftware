<?php

namespace App\Models;

use App\Services\ShardManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $data)
 * @method static where(string $string, $id)
 * @method static paginate(int $paginate)
 * @method static findOrFail($id)
 */
class Post extends Model
{
    protected $connection;

    public function useShard(string $connection)
    {
        $this->setConnection($connection);
        return $this;
    }

    protected $fillable = [
        'id',
        'title',
        'body',
        'likes',
        'dislikes',
        'created_by'
    ];

    protected $keyType = 'string'; // Ensure that the primary key is treated as a string (UUID)
    public $incrementing = false; // Disable auto-increment

    public function Likes() : hasMany
    {
        return $this->hasMany(Like::class);
    }
}
