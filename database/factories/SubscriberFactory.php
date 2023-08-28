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

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'subscriber_id' => User::inRandomOrder()->first()->id,
            'subscription_level' => $this->faker->randomElement(['tier1', 'tier2', 'tier3']),
            'created_at' => Carbon::createFromTimestamp(rand($oldestDateLimit->timestamp, Carbon::now()->timestamp)),
        ];
    }

}
