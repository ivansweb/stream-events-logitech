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
    public function getEvents(int $userId): array
    {
        return $this->repository->getEventsByUser($userId);
    }

    /**
     * @param int $id
     * @return bool|array
     */
    public function markAsRead(int $id): bool|array
    {
        $res = $this->repository->markAsRead($id);

        return !empty($res) ? true : array('error' => 'Could not mark event as read');
    }

    /**
     * @param int $id
     * @return bool|array
     */
    public function markAsUnread(int $id): bool|array
    {
        $res = $this->repository->markAsUnread($id);

        return !empty($res) ? true : array('error' => 'Could not mark event as unread');
    }


}
