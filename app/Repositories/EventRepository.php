<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Event;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class EventRepository
 * @package App\Repositories
 */
class EventRepository extends Repository
{
    protected Model $model;

    /**
     * Dependency Injector
     *
     * @param Event $model
     * @throws Exception
     */
    public function __construct(Event $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getEventsByUser(int $userId)
    {
        $events = $this->model
            ->where('user_id',  $userId)
            ->get();

        return $events->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function markAsRead(int $id): array
    {
        $event = $this->model->find($id);
        $event->read = true;
        $event->save();

        return $event->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function markAsUnread(int $id): array
    {
        $event = $this->model->find($id);
        $event->read = false;
        $event->save();

        return $event->toArray();
    }




}
