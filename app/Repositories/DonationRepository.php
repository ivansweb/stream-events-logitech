<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Donation;
use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DonationRepository
 * @package App\Repositories
 */
class DonationRepository extends Repository
{

    protected Model $model;

    /**
     * Dependency Injector
     *
     * @param Donation $model
     * @throws Exception
     */
    public function __construct(Donation $model)
    {
        parent::__construct($model);
    }

}
