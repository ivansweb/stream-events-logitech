<?php

declare(strict_types=1);

namespace App\Repositories;

use Exception;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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


    /**
     * Get user's top sales
     *
     * @param int $userId
     * @param int $bestSalesQuantity
     * @return Builder[]|Collection
     */
    public function getTopSales(int $userId, int $bestSalesQuantity): array|Collection
    {
       return MerchSale::select('user_id', 'item_name', DB::raw('SUM(amount) as total'))
            ->where('user_id', $userId)
            ->groupBy('user_id', 'item_name')
            ->orderByDesc('total')
            ->limit($bestSalesQuantity)
            ->get();
    }

    /**
     *
     * @param int $id
     * @param array $params
     * @return object|null
     */
    public function findWithRelations(int $id, array $params = []): object|null
    {
        return $this->model
            ->query()
            ->where('id', $id)
            ->with([
                'subscribers' => function ($query) use ($params) {
                    $query->when(
                        isset($params['created_at']),
                        function ($query) use ($params) {
                            $query->where('created_at', '>=', $params['created_at']);
                        }
                    );
                },
                'donations' => function ($query) use ($params) {
                    $query->when(
                        isset($params['created_at']),
                        function ($query) use ($params) {
                            $query->where('created_at', '>=', $params['created_at']);
                        }
                    );
                },
                'merchSales' => function ($query) use ($params) {
                    $query->when(isset($params['created_at']), function ($subQuery) use ($params) {
                        $subQuery->where('created_at', '>=', $params['created_at']);
                    })->orderByDesc('amount')
                        ->limit($params['limit'] ?? null);
                },
                'followers' => function ($query) use ($params) {
                    $query->when(
                        isset($params['created_at']),
                        function ($query) use ($params) {
                            $query->where('created_at', '>=', $params['created_at']);
                        }
                    );
                },
            ])->first();
    }

}
