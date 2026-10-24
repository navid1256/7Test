<?php

namespace App\repositories\Eloquent;

use App\repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Override;

abstract class EloquentBaseRepository implements RepositoryInterface
{
    protected string $model;

    #[Override]
    public function create(array $data): Model
    {
        return $this->model::create($data);
    }

    #[Override]
    public function update(int $id, array $data): ?Model
    {
        $record = $this->find($id);

        if (! $record) {
            return null;
        }

        $record->update($data);

        return $record->fresh();
    }

    #[Override]
    public function all(array $where = []): Collection
    {
        return $this->applyWhere($this->model::query(), $where)->get();
    }

    #[Override]
    public function delete(array $where): int
    {
        return $this->applyWhere($this->model::query(), $where)->delete();
    }

    #[Override]
    public function find(int $id): ?Model
    {
        return $this->model::find($id);
    }

    private function applyWhere(Builder $query, array $where): Builder
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);

                continue;
            }

            $query->where($field, $value);
        }

        return $query;
    }
}
