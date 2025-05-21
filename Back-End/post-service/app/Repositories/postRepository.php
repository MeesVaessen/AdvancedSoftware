<?php

namespace App\Repositories;

use App\Models\Like;
use App\Models\Post;
use App\Repositories\Interfaces\postLookupRepositoryInterface;
use App\Repositories\Interfaces\postRepositoryInterface;
use App\Services\ShardManager;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class postRepository implements postRepositoryInterface
{
    public function __construct(protected ShardManager $shardManager, protected postLookupRepositoryInterface $postLookupRepository)
    {
    }

    protected function getShardConnection(string $userUuid): string
    {
        return $this->shardManager->getConnectionName($userUuid);
    }

    public function store(array $data)
    {
        $connection = $this->getShardConnection($data['created_by']);
        $postId = Str::uuid();

        $post = (new Post)
            ->useShard($connection)
            ->create([
                'id' => $postId,
                'title' => $data['title'],
                'body' => $data['body'],
                'created_by' => $data['created_by'],
            ]);
        $this->postLookupRepository->createLookup($postId, $connection);
        return $post;
    }

    public function show($id)
    {
        $lookup = $this->postLookupRepository->getLookup($id);

        if (!$lookup) {
            return null;
        }

        return (new Post)
            ->useShard($lookup->shard)
            ->where('id', $id)
            ->first();
    }

    public function showAll($paginate = null): LengthAwarePaginator
    {
        $perPage = $paginate ?? 15;
        $currentPage = request()->input('page', 1);
        $cacheKey = "posts_page_{$currentPage}_perpage_{$perPage}";

        $cachedPosts = Redis::get($cacheKey);

        if ($cachedPosts) {
            $postsArray = json_decode($cachedPosts, true);
            $posts = collect($postsArray)->map(fn($post) => new Post((array)$post));
            $total = Redis::get('posts_total') ?: 0;

            return new LengthAwarePaginator(
                $posts,
                $total,
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }
        // Cache miss: fetch from DB
        $lookupQuery = DB::connection('central')->table('post_shard_lookup')
            ->orderBy('created_at', 'desc');

        $total = $lookupQuery->count();

        $postLookups = $lookupQuery->forPage($currentPage, $perPage)->get();

        $posts = collect();

        foreach ($postLookups as $lookup) {
            $post = (new Post)->useShard($lookup->shard)->find($lookup->post_id);
            if ($post) {
                $posts->push($post);
            }
        }

        $posts->each(fn($post) => $this->getPostLikes($post));

        // Cache posts and total count in Redis for, e.g., 5 minutes
        Redis::setex($cacheKey, 300, $posts->toJson());
        Redis::setex('posts_total', 300, $total);

        return new LengthAwarePaginator(
            $posts,
            $total,
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }



    public function update(array $data, $id)
    {
        $lookup = $this->postLookupRepository->getLookup($id);
        if (! $lookup) {
            throw new NotFoundHttpException('Post not found');
        }

        $post = (new Post)->useShard($lookup->shard)->findOrFail($id);

        if ($post->created_by == $data['created_by']) {
            $post->update($data);
            return $post;
        }

        throw new UnauthorizedException;
    }

    public function reactToPost(array $data, bool $isLike): array
    {
        $lookup = $this->getLookup($data['postId']);
        $connection = $lookup->shard;

        DB::connection($connection)->transaction(function () use ($data, $connection, $isLike) {
            $like = (new Like)->setConnection($connection)
                ->where('user_id', $data['userId'])
                ->where('post_id', $data['postId'])
                ->lockForUpdate()
                ->first();

            if ($like) {
                if ($like->is_like == $isLike) {
                    DB::connection($connection)->table('likes')
                        ->where('user_id', $data['userId'])
                        ->where('post_id', $data['postId'])
                        ->delete();
                } else {

                    DB::connection($connection)->table('likes')
                        ->where('user_id', $data['userId'])
                        ->where('post_id', $data['postId'])
                        ->update([
                            'is_like' => $isLike,
                            'updated_at' => now(),
                        ]);
                }
            } else {
                (new Like)->setConnection($connection)->create([
                    'user_id' => $data['userId'],
                    'post_id' => $data['postId'],
                    'is_like' => $isLike,
                ]);
            }
        });

        return $this->countLikesDislikes($data['postId'], $connection);
    }


    public function delete($id)
    {
        $lookup = $this->postLookupRepository->getLookup($id);
        if (! $lookup) {
            throw new NotFoundHttpException('Post not found');
        }

        $post = (new Post)->useShard($lookup->shard)->findOrFail($id);
        return $post->delete();
    }

    private function getPostLikes($post): void
    {
        $lookup = $this->postLookupRepository->getLookup($post->id);
        if (! $lookup) {
            $post->likes = 0;
            $post->dislikes = 0;
            return;
        }

        $connection = $lookup->shard;

        $likes = (new Like)->setConnection($connection)
            ->where('post_id', $post->id)
            ->where('is_like', true)
            ->count();

        $dislikes = (new Like)->setConnection($connection)
            ->where('post_id', $post->id)
            ->where('is_like', false)
            ->count();

        $post->likes = $likes;
        $post->dislikes = $dislikes;
    }

    private function countLikesDislikes(string $postId, string $connection): array
    {
        return [
            'Likes' => (new Like)->setConnection($connection)
                ->where('post_id', $postId)
                ->where('is_like', true)
                ->count(),
            'Dislikes' => (new Like)->setConnection($connection)
                ->where('post_id', $postId)
                ->where('is_like', false)
                ->count(),
        ];
    }

    /**
     * @param $postId
     * @return mixed
     */
    private function getLookup($postId): mixed
    {
        $lookup = $this->postLookupRepository->getLookup($postId);
        if (!$lookup) {
            throw new NotFoundHttpException('Post not found');
        }
        return $lookup;
    }


}
