<?php

namespace App\Repositories;

use App\Models\Like;
use App\Models\Post;
use App\Repositories\Interfaces\postRepositoryInterface;
use App\Services\ShardManager;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class postRepository implements postRepositoryInterface
{
    protected ShardManager $shardManager;

    public function __construct(ShardManager $shardManager)
    {
        $this->shardManager = $shardManager;
    }

    protected function getShardConnection(string $userUuid): string
    {
        return $this->shardManager->getConnectionName($userUuid);
    }

    public function store(array $data)
    {
        $connection = $this->getShardConnection($data['created_by']);

        return (new Post)
            ->useShard($connection)
            ->create([
                'id' => Str::uuid(),
                'title' => $data['title'],
                'body' => $data['body'],
                'created_by' => $data['created_by'],
            ]);
    }

    public function show($id)
    {
        $post = $this->usePostShard($userUuid)->findOrFail($id);
        $this->getPostLikes($post);

        return $post;
    }

    public function showAll($paginate = null)
    {
        $posts = $paginate ? Post::paginate($paginate) : Post::all();
        foreach ($posts as $post) {
            $this->getPostLikes($post);
        }

        return $posts;
    }

    public function update(array $data, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->created_by == $data['created_by']) {
            $post->update($data);

            return $post;
        }
        throw new UnauthorizedException;
    }

    public function likePost($data): array
    {
        $post = Post::find($data['postId']);
        if (! $post) {
            throw new NotFoundHttpException('Post not found');
        }

        $like = Like::where('user_id', $data['userId'])->where('post_id', $data['postId'])->first();

        if ($like) {
            if (! $like->is_like) {
                $like->where('user_id', $data['userId'])->where('post_id', $data['postId'])->update(['is_like' => true]);
            } else {
                $like->where('user_id', $data['userId'])->where('post_id', $data['postId'])->delete();
            }
        } else {
            Like::create([
                'user_id' => $data['userId'],
                'post_id' => $data['postId'],
                'is_like' => true,
            ]);
        }

        return [
            'Likes' => Like::where('post_id', $data['postId'])->where('is_like', true)->count(),
            'Dislikes' => Like::where('post_id', $data['postId'])->where('is_like', false)->count(),
        ];
    }

    public function dislikePost($data): array
    {
        $post = Post::find($data['postId']);
        if (! $post) {
            throw new NotFoundHttpException('Post not found');
        }

        $like = Like::where('user_id', $data['userId'])->where('post_id', $data['postId'])->first();

        if ($like) {
            if ($like->is_like) {
                $like->where('user_id', $data['userId'])->where('post_id', $data['postId'])->update(['is_like' => false]);
            } else {
                $like->where('user_id', $data['userId'])->where('post_id', $data['postId'])->delete();
            }
        } else {
            Like::create([
                'user_id' => $data['userId'],
                'post_id' => $data['postId'],
                'is_like' => false,
            ]);
        }

        return [
            'Likes' => Like::where('post_id', $data['postId'])->where('is_like', true)->count(),
            'Dislikes' => Like::where('post_id', $data['postId'])->where('is_like', false)->count(),
        ];

    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);

        return $post->delete();
    }

    /**
     * @param  $id
     */
    private function getPostLikes($post): void
    {
        $likes = Like::where('post_id', $post->id)->where('is_like', true)->count();
        $dislikes = Like::where('post_id', $post->id)->where('is_like', false)->count();
        $post->likes = $likes;
        $post->dislikes = $dislikes;
    }
}
