<?php

namespace App\repositories\Eloquent;

use App\Models\User;
use App\repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Override;

class EloquentUserRepository implements RepositoryInterface
{
    protected string $model;

    public function __construct(?string $model = null)
    {
        $this->model = $model ?? User::class;
    }

    #[Override]
    public function create(array $data)
    {
        return $this->model::create($data);
    }

    #[Override]
    public function update(int $id, array $data)
    {
        $record = $this->find($id);

        if (! $record) {
            return null;
        }

        $record->update($data);

        return $record->fresh();
    }

    #[Override]
    public function all(array $where = [])
    {
        $query = $this->model::query();

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);

                continue;
            }

            $query->where($field, $value);
        }

        return $query->get();
    }

    #[Override]
    public function delete(array $where)
    {
        $query = $this->model::query();

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);

                continue;
            }

            $query->where($field, $value);
        }

        return $query->delete();
    }

    #[Override]
    public function find(int $id)
    {
        return $this->model::find($id);
    }
}
