<?php

namespace App\Services;

use App\Repositories\Interfaces\postRepositoryInterface;
use App\Services\Interfaces\postServiceInterface;

class postService implements postServiceInterface
{
    public function __construct(protected postRepositoryInterface $postRepository) {}

    public function create(array $data)
    {
        return $this->postRepository->store($data);
    }

    public function getAll($paginate)
    {
        return $this->postRepository->showAll($paginate);
    }

    public function get($id)
    {
        return $this->postRepository->show($id);
    }

    public function update($id, array $data)
    {
        return $this->postRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->postRepository->delete($id);
    }

    public function like($data)
    {
        return $this->postRepository->reactToPost($data, true);

    }

    public function dislike($data)
    {
        return $this->postRepository->reactToPost($data, false);
    }
}
