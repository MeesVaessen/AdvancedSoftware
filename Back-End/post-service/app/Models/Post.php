<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static where(string $string, $id)
 * @method static paginate(int $paginate)
 * @method static findOrFail($id)
 */
class Post extends Model
{
    protected $fillable = [
        'id',
        'title',
        'body',
        'likes',
        'dislikes',
        'created_by'
    ];
}
