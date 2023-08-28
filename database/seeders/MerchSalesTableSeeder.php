<?php

namespace Database\Seeders;

use App\Models\MerchSale;
use Illuminate\Database\Seeder;

class MerchSalesTableSeeder extends Seeder
{
    public function run(): void
    {
        MerchSale::factory(600)->create();
    }
}

