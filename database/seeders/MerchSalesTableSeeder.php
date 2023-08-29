<?php

namespace Database\Seeders;

use App\Models\MerchSale;
use App\Models\User;
use Illuminate\Database\Seeder;

class MerchSalesTableSeeder extends Seeder
{
    public function run(): void
    {
        $totalUsers = User::count() * 3;
        MerchSale::factory($totalUsers)->create();
    }
}

