<?php

namespace App\Http\Controllers;

use App\Services\EventService;

class EventController extends Controller
{
    /**
     * @var EventService
     */
    public EventService $service;

    /**
     * Dependency Injector
     *
     * @param EventService $service
     */
    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    public function markAsRead($id)
    {
        return $this->service->markAsRead($id);
    }

    public function markAsUnread($id)
    {
        return $this->service->markAsUnread($id);
    }
}
