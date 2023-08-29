<?php

namespace Database\Factories;

use App\Models\MerchSale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class MerchSaleFactory extends Factory
{
    protected $model = MerchSale::class;

    public function definition(): array
    {
        $oldestDateLimit = Carbon::now()->subMonths(3);

        $products = [
            'T-Shirt',
            'Hoodie',
            'Mug',
            'Sticker',
            'Hat',
            'Poster',
            'Socks',
            'Keychain'
        ];

        $userIds = User::pluck('id')->toArray();
        $user = User::inRandomOrder()->first();
        $donorIds = array_diff($userIds, [$user->id]);

        return [
            'item_name' => $this->faker->randomElement($products),
            'amount' => $this->faker->randomNumber(1),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'user_id' => $user->id,
            'buyer_id' => $this->faker->randomElement($donorIds),
            'created_at' => Carbon::createFromTimestamp(rand($oldestDateLimit->timestamp, Carbon::now()->timestamp)),
        ];
    }
}

