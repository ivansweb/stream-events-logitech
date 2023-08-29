<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\SubscriberRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class IndicatorService
 * @package App\Services
 */
class IndicatorService extends Service
{
    /**
     * Dependency Injector
     *
     * @param UserRepository $repository
     * @throws Exception
     */
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getUser(int $userId, array $params): object|null
    {
        return $this->repository->findWithRelations($userId, $params);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getSubscribers(int $userId): array
    {
        $params = [
            'created_at' => Carbon::now()->subDays(30)->toDateTimeString(),
        ];
        $user = $this->getUser($userId, $params);
        $subscribers = $user->subscribers;

        /*
         * TODO: This should be pulled from a database
         */
        $subscriptionTiers = [
            'tier1' => 5,
            'tier2' => 10,
            'tier3' => 15,
        ];

        $subscribersByLevel = [];
        $totalInSubscriptions = 0;

        foreach ($subscribers->groupBy('subscription_level') as $subscriptionLevel => $subscribersGroup) {
            $total = count($subscribersGroup) * $subscriptionTiers[$subscriptionLevel];
            $totalInSubscriptions += $total;
            $subscribersByLevel[$subscriptionLevel] = '$ ' . number_format($total, 2, '.', ',');
        }

        return [
            'total' => $totalInSubscriptions,
            'by_tier' => $subscribersByLevel,
            'subscribers' => $subscribers->toArray(),
        ];
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getFollowers(int $userId): array
    {
        $params = [
            'created_at' => Carbon::now()->subDays(30)->toDateTimeString(),
        ];
        $user = $this->getUser($userId, $params);

        return $user->followers->toArray();
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getDonations(int $userId): array
    {
        $params = [
            'created_at' => Carbon::now()->subDays(30)->toDateTimeString(),
        ];
        $user = $this->getUser($userId, $params);

        $donations = $user->donations;
        $groupedDonations = $donations->groupBy('currency');

        $currencySymbols = [
            'USD' => '$',
            'CAD' => '$',
            'AUD' => '$',
            'EUR' => '€',
            'GBP' => '£',
        ];

        $donationsByCurrency = [];

        foreach ($groupedDonations as $currency => $groupedDonation) {
            $symbol = $currencySymbols[$currency] ?? '';
            $formattedAmount = $symbol . ' ' . number_format($groupedDonation->sum('amount'), 2, '.', ',');

            $donationsByCurrency[$currency] = $formattedAmount;
        }

        return [
            'total' => $donations->sum('amount'),
            'by_currency' => $donationsByCurrency,
        ];
    }

    /**
     *
     * TODO: The products are static, but a new table must be created with the products and inventory control
     * and their relationships
     *
     * @param int $userId
     * @return string[]
     */
    public function getMerchSales(int $userId): array
    {
        $bestSalesQuantity = 3;
        $params = [
            'created_at' => Carbon::now()->subDays(30)->toDateTimeString(),
            'limit' => $bestSalesQuantity,
        ];
        $user = $this->getUser($userId, $params);

        $merchSales = $user->merchSales;

        $userTopSales = $this->repository->getTopSales($user->id, $bestSalesQuantity);

        return [
            'total' => $merchSales->sum('amount'),
            'top_sales' => $userTopSales->toArray(),
        ];
    }


    /**
     * @param int $userId
     * @return array
     */
    public function getSubscribersEvents(int $userId): array
    {
        $params = [
            'created_at' => Carbon::now()->subDays(30)->toDateTimeString(),
        ];
        $subscribers = $this->subscriberRepository->getSubscribers($userId, $params);

        $subscriptionMessages = [];

        foreach ($subscribers as $subscriber) {
            $message = "{$subscriber->subscriber_name} ({$subscriber->subscription_level}) subscribed to you!";
            $subscriptionMessages[] = $message;
        }

        dd(
            $subscriptionMessages
        );


        return [
            'subscribers' => $subscribers->toArray(),
        ];
    }

}
