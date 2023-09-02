<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\DonationRepository;
use App\Repositories\EventRepository;
use App\Repositories\FollowerRepository;
use App\Repositories\MerchSaleRepository;
use App\Repositories\SubscriberRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class UserService
 * @package App\Services
 */
class UserService extends Service
{

    public SubscriberRepository $subscribersRepository;
    public FollowerRepository $followerRepository;
    public DonationRepository $donationRepository;
    public MerchSaleRepository $merchSaleRepository;
    public EventRepository  $eventRepository;

    /**
     * Dependency Injector
     *
     * @param UserRepository $repository
     * @param SubscriberRepository $subscribersRepository
     * @param FollowerRepository $followerRepository
     * @param DonationRepository $donationRepository
     * @param MerchSaleRepository $merchSaleRepository
     * @throws Exception
     */
    public function __construct(
        UserRepository $repository,
        SubscriberRepository $subscribersRepository,
        FollowerRepository $followerRepository,
        DonationRepository $donationRepository,
        MerchSaleRepository $merchSaleRepository,
        EventRepository $eventRepository
    )
    {
        $this->subscribersRepository = $subscribersRepository;
        $this->followerRepository = $followerRepository;
        $this->donationRepository = $donationRepository;
        $this->merchSaleRepository = $merchSaleRepository;
        $this->eventRepository = $eventRepository;
        parent::__construct($repository);
    }

    public function getAccessToken(User|Authenticatable $user): string
    {
        $user->tokens()->delete();
        return $user->createToken('Laravel Password Grant Client')->plainTextToken;
    }

    /**
     * Create or sign in user
     *
     * @param array $user
     * @param string $provider
     * @return string|null
     * @throws Exception
     */
    public function createOrGetUser(array $user, string $provider): ?string
    {
        try {
            $findUser = $this->repository->findUserBySocialId($provider, $user['id']);

            if (!$findUser) {
                $user = $this->repository->create([
                    "name" =>  $user['name'],
                    "email" =>  $user['email'],
                    "password" => Hash::make(Str::random(10)),
                    "social_id" => $user['id'],
                    "social_type" => $provider,
                    "remember_token" => Str::random(10),
                    "expires_at" => Carbon::now()->addDays(365)->toDateTimeString()
                ]);

                $userId = $user->id;
            }else{
                $userId = $findUser->id;
            }

            return Crypt::encrypt($userId);

        }catch (Exception $e) {
            Log::error('<' . __METHOD__ . '> :: ' . print_r($e->getMessage(), true));
            return null;
        }

    }

    /**
     * Get user token
     *
     * @param string $userId
     * @return array
     */
    public function getToken(string $userId): array
    {
        $userId = Crypt::decrypt($userId);
        $user = $this->repository->find($userId);

        Auth::login($user);

        return [
            'userId' => $user->id,
            'userName' => $user->name,
            'token' => $this->getAccessToken($user)
        ];
    }

    /**
     * Fill data - only to the test functionality
     *  get the first 50 rows from each table and update the user_id column with the current user id
     *
     * @return array
     * @throws Exception
     */
    public function fillData(): array
    {
        $userId = Auth::user()->id;
        $quantityOfRows = rand(40, 60);

        $followers = $this->followerRepository->getAll()->toArray()['data'];

        for ($i = 0; $i < $quantityOfRows; $i++) {
            $paramsToFill =[
                'id' => $followers[$i]['id'],
                'user_id' => $userId
            ];
            $this->followerRepository->update($paramsToFill);
        }

        $subscribers = $this->subscribersRepository->getAll()->toArray()['data'];

        for ($i = 0; $i < $quantityOfRows; $i++) {
            $paramsToFill =[
                'id' => $subscribers[$i]['id'],
                'user_id' => $userId
            ];
            $this->subscribersRepository->update($paramsToFill);
        }

        $donations = $this->donationRepository->getAll()->toArray()['data'];

        for ($i = 0; $i < $quantityOfRows; $i++) {
            $paramsToFill =[
                'id' => $donations[$i]['id'],
                'user_id' => $userId
            ];
            $this->donationRepository->update($paramsToFill);
        }

        $merchSales = $this->merchSaleRepository->getAll()->toArray()['data'];

        for ($i = 0; $i < $quantityOfRows; $i++) {
            $paramsToFill =[
                'id' => $merchSales[$i]['id'],
                'user_id' => $userId
            ];
            $this->merchSaleRepository->update($paramsToFill);
        }

        $events = $this->eventRepository->getAll()->toArray()['data'];

        for ($i = 0; $i < $quantityOfRows; $i++) {
            $paramsToFill =[
                'id' => $events[$i]['id'],
                'user_id' => $userId
            ];
            $this->eventRepository->update($paramsToFill);
        }


        return [
            'status' => 'success',
        ];
    }

}
