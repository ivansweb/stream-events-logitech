<?php

namespace Database\Seeders;

use App\Models\Donation;
use Illuminate\Database\Seeder;

class DonationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Donation::factory(600)->create();
    }
}
