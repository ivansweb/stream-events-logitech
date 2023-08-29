<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\EventRepository;
use Exception;

/**
 * Class EventService
 * @package App\Services
 */
class EventService extends Service
{
    /**
     * Dependency Injector
     *
     * @param EventRepository $repository
     * @throws Exception
     */
    public function __construct(EventRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getEvents(int $userId)
    {
        return $this->repository->getEventsByUser($userId);
    }

}
