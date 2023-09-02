<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Subscriber;
use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubscriberRepository
 * @package App\Repositories
 */
class SubscriberRepository extends Repository
{

    protected Model $model;

    /**
     * Dependency Injector
     *
     * @param Subscriber $model
     * @throws Exception
     */
    public function __construct(Subscriber $model)
    {
        parent::__construct($model);
    }

}
