<?php

namespace App\Http\Common\Bases;

use App\Http\Common\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 * @package App\Common\Bases
 */
abstract class Repository
{
    /**
     * @var array $fillable
     */
    protected array $fillable = [];

    /**
     * @var Builder $query
     */
    public Builder $query;

    /**
     * Repository constructor.
     *
     * @throws RepositoryException
     */
    public function __construct()
    {
        $this->query();
    }

    /**
     * Specify Model class name
     *
     * @return String
     */
    abstract protected function model(): string;

    /**
     * Make query
     * @return Builder
     * @throws RepositoryException
     */
    public function query(): Builder
    {
        return $this->query = $this->makeModel()->newQuery();
    }

    /**
     * Make model
     *
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel(): Model
    {
        $model = app($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException(
                "Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model",
            );
        }

        return $model;
    }

    /**
     * Return all rows from table.
     *
     * @param array $relations
     * @param array|string[] $columns
     * @return Collection
     * @throws RepositoryException
     */
    public function all(array $relations =  [], array $columns = ['*']): Collection
    {
        return $this->query()->with($relations)->get($columns);
    }
}
