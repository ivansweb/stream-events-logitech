<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Follower;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FollowerRepository
 * @package App\Repositories
 */
class FollowerRepository extends Repository
{

    protected Model $model;

    /**
     * Dependency Injector
     *
     * @param Follower $model
     * @throws Exception
     */
    public function __construct(Follower $model)
    {
        parent::__construct($model);
    }

}
