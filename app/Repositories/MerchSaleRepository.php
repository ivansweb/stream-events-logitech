<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\MerchSale;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MerchSaleRepository
 * @package App\Repositories
 */
class MerchSaleRepository extends Repository
{

    protected Model $model;

    /**
     * Dependency Injector
     *
     * @param MerchSale $model
     * @throws Exception
     */
    public function __construct(MerchSale $model)
    {
        parent::__construct($model);
    }


}
