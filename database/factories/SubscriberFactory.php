<?php

namespace Database\Factories;

use App\Models\Subscriber;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriberFactory extends Factory
{
    protected $model = Subscriber::class;

    public function definition(): array
    {
        $oldestDateLimit = Carbon::now()->subMonths(3);

        $userIds = User::pluck('id')->toArray();
        $user = User::inRandomOrder()->first();
        $subscribersIds = array_diff($userIds, [$user->id]);
        shuffle($subscribersIds);
        $subscriberId = array_shift($subscribersIds);

        return [
            'user_id' => $user->id,
            'subscriber_id' => $subscriberId,
            'subscription_level' => $this->faker->randomElement(['tier1', 'tier2', 'tier3']),
            'created_at' => Carbon::createFromTimestamp(rand($oldestDateLimit->timestamp, Carbon::now()->timestamp)),
        ];
    }

}
