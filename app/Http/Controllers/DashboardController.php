<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use App\Services\IndicatorService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * @var IndicatorService
     */
    public IndicatorService $service;

    /**
     * @var EventService
     */
    public EventService $eventService;

    /**
     * @var UserService
     */
    public UserService $userService;

    /**
     * Dependency Injector
     *
     * @param IndicatorService $indicatorService
     * @param EventService $eventService
     * @param UserService $userService
     */
    public function __construct(
        IndicatorService $indicatorService,
        EventService $eventService,
        UserService $userService
    )
    {
        $this->service = $indicatorService;
        $this->eventService = $eventService;
        $this->userService = $userService;
    }

    public function index(): Response
    {
        return Inertia::render('Dashboard');
    }

    public function login(): Response
    {
        return Inertia::render('Login');
    }

    public function getStats(Request $request)
    {
        $subscribers = $this->service->getSubscribers($request->user()->id);
        $followers = $this->service->getFollowers($request->user()->id);
        $donations = $this->service->getDonations($request->user()->id);
        $merchSales = $this->service->getMerchSales($request->user()->id);

        $total = $subscribers['total'] + $donations['total'] + $merchSales['total'];

        return response()->json([
            [
                'id' => 1,
                'name' => 'Total Revenue',
                'stat' => '$' . number_format($total, 2, '.', ','),
            ],
            [
                'id' => 2,
                'name' => 'Followers',
                'stat' => count($followers),
            ],
            [
                'id' => 3,
                'name' => 'Merch Sales',
                'stat' => $merchSales['top_sales'],
            ],
        ]);

    }

    public function getEvents(Request $request)
    {
        $events = $this->eventService->getEvents($request->user()->id);
        return response()->json($events);

    }

    public function fillData()
    {
        try {
            return response()->json(
                $this->userService->fillData()
            );
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
