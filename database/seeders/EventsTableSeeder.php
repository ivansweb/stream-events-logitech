<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscribers = Subscriber::select(
            'users1.name as user_name',
            'users2.name as subscriber_name',
            'subscribers.created_at',
            'subscribers.subscription_level',
            'subscribers.user_id',
            'subscribers.subscriber_id',
        )
            ->join('users as users1', 'users1.id', '=', 'subscribers.user_id')
            ->join('users as users2', 'users2.id', '=', 'subscribers.subscriber_id')
            ->get();


        foreach ($subscribers as $subscriber) {
            $message = "{$subscriber->subscriber_name} ({$subscriber->subscription_level}) subscribed to you!";
            Event::create([
                'message' => $message,
                'read' => false,
                'created_at' => $subscriber->created_at,
                'user_id' => $subscriber->user_id,
            ]);
        }
    }
}
