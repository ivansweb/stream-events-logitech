<?php

declare(strict_types=1);

namespace App\Repositories;

use Exception;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends Repository
{

    protected Model $model;

    /**
     * Dependency Injector
     *
     * @param User $model
     * @throws Exception
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Find user by social id
     *
     * @param string $provider
     * @param string $socialId
     * @return User|null
     */
    public function findUserBySocialId(string $provider, string $socialId): ?User
    {
        return $this->model
            ->where('social_type', $provider)
            ->where('social_id', $socialId)
            ->first();
    }

}
