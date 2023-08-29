<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonationFactory extends Factory
{
    protected $model = Donation::class;

    public function definition()
    {
        $oldestDateLimit = Carbon::now()->subMonths(3);
        $currencies = ['USD', 'EUR', 'GBP', 'CAD', 'AUD'];

        $userIds = User::pluck('id')->toArray();
        $user = User::inRandomOrder()->first();
        $donorIds = array_diff($userIds, [$user->id]);

        return [
            'user_id' => $user->id,
            'donor_id' => $this->faker->randomElement($donorIds),
            'amount' => $this->faker->randomFloat(2, 1, 1000),
            'currency' => $this->faker->randomElement($currencies),
            'donation_message' => $this->faker->sentence,
            'created_at' => Carbon::createFromTimestamp(rand($oldestDateLimit->timestamp, Carbon::now()->timestamp)),

        ];
    }
}
