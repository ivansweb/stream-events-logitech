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

        /*
         *  this logic serves to ensure that the user_id and follower_id are not the same
         */
        $userIds = User::pluck('id')->toArray();
        $user = User::inRandomOrder()->first();
        $followerIds = array_diff($userIds, [$user->id]);
        shuffle($followerIds);
        $followerId = array_shift($followerIds);

        return [
            'user_id' => $user->id,
            'follower_id' => $followerId,
            'created_at' => Carbon::createFromTimestamp(rand($oldestDateLimit->timestamp, Carbon::now()->timestamp)),
        ];
    }
}
