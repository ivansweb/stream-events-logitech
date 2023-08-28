<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use App\Repositories\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


/**
 * Class Service
 *
 * @package App\Services
 */
abstract class Service
{
    const ERROR = 'ERROR';

    /**
     * @var Repository
     */
    protected Repository $repository;

    /**
     * Constructor
     *
     * @param Repository|null $repository
     * @throws Exception
     */
    public function __construct(Repository $repository = null)
    {
       $this->repository = $repository;
    }

    /**
     * Create an entity
     *
     * @param array $params
     * @return mixed
     */
    public function create(array $params = []): mixed
    {
        return $this->repository->create($params);
    }

    /**
     * Update an entity
     *
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function update(array $params = []): mixed
    {
        return $this->repository->update($params);
    }

    /**
     * Delete an entity by id
     *
     * @param string|null $id
     * @return mixed
     * @throws Exception
     */
    public function delete(string $id = null): mixed
    {
        return $this->repository->delete($id);
    }

    /**
     * Get all data
     *
     * @param array $params
     * @return array|LengthAwarePaginator
     */
    public function getAll(array $params = []): LengthAwarePaginator|array
    {
        return $this->repository->getAll($params);
    }

    /**
     * Get entity by id
     *
     * @param int|null $id
     * @return mixed
     * @throws Exception
     */
    public function find(int $id = null): mixed
    {
        return $this->repository->find($id);
    }
}
