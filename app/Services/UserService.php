<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
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

    public function getAccessToken(User|Authenticatable $user): string
    {
        $userTokens = $user->tokens;

        if ( count($userTokens) === 0){
            return $user->createToken('Token Grant')->plainTextToken;
        }

        return "{$userTokens[0]->token}";
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
            'userId' => $userId,
            'token' => $this->getAccessToken($user)
        ];
    }

}
