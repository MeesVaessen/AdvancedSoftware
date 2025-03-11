<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\postRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class postRepository implements postRepositoryInterface
{
    public function store(array $data)
    {
        return Post::create([
            'id' => Str::uuid(),
            'title' => $data['title'],
            'body' => $data['body'],
            'created_by' => '',
        ]);
    }

    public function show($id)
    {
        return Post::findOrFail($id);
    }

    public function showAll($paginate = null): Collection
    {
        return $paginate ? Post::paginate($paginate) : Post::all();
    }

    public function update(array $data, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        return $post->delete();
    }
}
