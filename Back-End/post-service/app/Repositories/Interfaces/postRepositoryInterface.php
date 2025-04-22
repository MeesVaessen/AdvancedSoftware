<?php

namespace App\Repositories\Interfaces;

interface postRepositoryInterface
{
    public function store(array $data);

    public function show($id);

    public function showAll($paginate);

    public function update(array $data, $id);

    public function likePost($data);

    public function dislikePost($data);

    public function delete($id);
}
