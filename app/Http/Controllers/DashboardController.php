<?php

namespace App\Http\Controllers;

use App\Services\IndicatorService;
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
     * Dependency Injector
     *
     * @param IndicatorService $indicatorService
     */
    public function __construct(IndicatorService $indicatorService)
    {
        $this->service = $indicatorService;
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
            'revenue' => [
                'subscribers' => $subscribers['by_tier'],
                'donations' => $donations['by_currency'],
                'merch_sales' => $merchSales,
                'total' => '$' . number_format($total, 2, '.', ','),
            ],
            'followers' => count($followers),
        ]);

    }
}
