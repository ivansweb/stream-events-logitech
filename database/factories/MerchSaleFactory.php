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

        return [
            'item_name' => $this->faker->word,
            'amount' => $this->faker->randomNumber(1),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'user_id' => User::inRandomOrder()->first()->id,
            'buyer_id' => User::inRandomOrder()->first()->id,
            'created_at' => Carbon::createFromTimestamp(rand($oldestDateLimit->timestamp, Carbon::now()->timestamp)),
        ];
    }
}

