<?php

declare(strict_types=1);

namespace App\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\{Builder, Collection, Model};

/**
 * Class Repository
 * @package App\Repositories
 */
abstract class Repository
{
    const PER_PAGE = 100;

    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @param Model|null $model
     * @throws Exception
     */
    public function __construct(Model $model = null)
    {
        if (is_null($model)) {
            throw new Exception('Model is required');
        }

        $this->model = $model;
    }

    /**
     * @return Model
     */
    protected function model(): Model
    {
        return $this->model;
    }

    /**
     * Get all data
     * @param array $params
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function getAll(array $params = []): Collection|LengthAwarePaginator|array
    {
        $query = $this->model->query();

        if (count($params)) {
            foreach ($params as $param => $value) {
                $query->where($param, $value);
            }
            return $query->get();
        }

        return $query->paginate(!empty($params['per_page']) ? $params['per_page'] : self::PER_PAGE);
    }

    /**
     * Create new entity
     *
     * @param array $params
     * @return mixed
     */
    public function create(array $params = []): mixed
    {
        $this->model->fill($params);
        return $this->model->create($params);
    }

    /**
     * Update an entity
     *
     * @param array $params
     * @return null
     * @throws Exception
     */
    public function update(array $params = []): mixed
    {
        if (empty($params['id'])) {
            throw new Exception('Id is required to update');
        }

        $vo = $this->model->where('id', $params['id'])->first();

        if (is_null($vo)) {
            throw new Exception('No entity found');
        }

        $vo->fill($params);
        $vo->save();
        return $vo;
    }

    /**
     * Delete an entity
     *
     * @param string|null $id
     * @return mixed
     * @throws Exception
     */
    public function delete(string $id = null): mixed
    {
        if (is_null($id)) {
            throw new Exception('Id is required to delete');
        }

        return $this->model->query()->where('id', $id)->delete();
    }

    /**
     * Get entity by id
     *
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model
    {
        return $this->model->query()->where('id', $id)->first();
    }

}
