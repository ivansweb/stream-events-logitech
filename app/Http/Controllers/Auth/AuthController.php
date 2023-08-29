<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * @var UserService
     */
    public UserService $service;

    /**
     * Dependency Injector
     *
     * @param UserService $userService
     * @throws Exception
     */
    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
     * Redirect to social login.
     *
     * @param string $provider
     * @return string|JsonResponse
     */
    public function loginWithProvider(string $provider): string|JsonResponse
    {
        try {
            return Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Handle callback from provider.
     * @param string $provider
     *
     * @return Response
     * @throws Exception
     */
    public function handleCallbackByProvider(string $provider): Response
    {
        $userAuthenticated = Socialite::driver($provider)->stateless()->user();

        $user = $this->service->createOrGetUser((array)$userAuthenticated, $provider);
        if(!$user){
            return Inertia::render('Login',[
                'message' => 'Something went wrong. Please try again.',
                'status' => 404
            ]);
        }

        return Inertia::render('Login',[
            'user' => $user,
            'message' => 'Success',
            'status' => 200
        ]);

    }

    /**
     * Handle callback from provider.
     * @param Request $request
     * @return array
     */
    public function getToken(Request $request): array
    {
        $response = $this->service->getToken($request->get('userId'));
        return [
            'userId' => $response['userId'],
            'userName' => $response['userName'],
            'token' => $response['token'],
        ];
    }
}
