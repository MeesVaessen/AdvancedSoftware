<?php

namespace App\Services\Interfaces;

interface postServiceInterface
{
    public function create(array$data);
    public function getAll($paginate);
    public function get($id);
    public function update($id, array $data);
    public function delete($id);
    public function like($data);
    public function dislike($data);



}
