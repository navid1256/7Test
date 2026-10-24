<?php

namespace App\repositories\Eloquent;

use App\repositories\Contracts\RepositoryInterface;

class EloquentBaseRepository implements RepositoryInterface
{
    public function create(array $data) 
    {
        
    }

    public function update(int $id, array $data) {}

    public function all(array $where) {}

    public function delete(array $where) {}

    public function find(int $id) {}
}
