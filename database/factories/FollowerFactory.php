<?php

namespace Database\Factories;

use App\Models\Follower;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowerFactory extends Factory
{
    protected $model = Follower::class;

    public function definition(): array
    {
        $oldestDateLimit = Carbon::now()->subMonths(3);

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'follower_id' => User::inRandomOrder()->first()->id,
            'created_at' => Carbon::createFromTimestamp(rand($oldestDateLimit->timestamp, Carbon::now()->timestamp)),
        ];
    }
}
