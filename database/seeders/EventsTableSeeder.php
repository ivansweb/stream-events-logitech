<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Event;
use App\Models\Follower;
use App\Models\MerchSale;
use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /*
         * Subscribers
         */
        $rows = Subscriber::select(
            'users1.name as user_name',
            'users2.name as subscriber_name',
            'subscribers.created_at',
            'subscribers.subscription_level',
            'subscribers.user_id',
            'subscribers.subscriber_id',
        )
            ->join('users as users1', 'users1.id', '=', 'subscribers.user_id')
            ->join('users as users2', 'users2.id', '=', 'subscribers.subscriber_id')
            ->limit(10)
            ->get();


        foreach ($rows as $row) {
            $message = "{$row->subscriber_name} ({$row->subscription_level}) subscribed to you!";
            Event::create([
                'message' => $message,
                'read' => false,
                'created_at' => $row->created_at,
                'user_id' => $row->user_id,
            ]);
        }

        /*
         * Followers
         */
        $rows = Follower::select(
            'users1.name as user_name',
            'users2.name as follower_name',
            'followers.created_at',
            'followers.user_id',
            'followers.follower_id',
        )
            ->join('users as users1', 'users1.id', '=', 'followers.user_id')
            ->join('users as users2', 'users2.id', '=', 'followers.follower_id')
            ->limit(10)
            ->get();


        foreach ($rows as $row) {
            $message = "{$row->follower_name} followed you!";
            Event::create([
                'message' => $message,
                'read' => false,
                'created_at' => $row->created_at,
                'user_id' => $row->user_id,
            ]);
        }

        /*
         * Donations
         */
        $rows = Donation::select(
            'users1.name as user_name',
            'users2.name as donor_name',
            'donations.*',
        )
            ->join('users as users1', 'users1.id', '=', 'donations.user_id')
            ->join('users as users2', 'users2.id', '=', 'donations.donor_id')
            ->limit(10)
            ->get();


        foreach ($rows as $row) {
            $message = "{$row->donor_name} donated {$row->amount} {$row->currency} to you! \"({$row->donation_message})\" ";
            Event::create([
                'message' => $message,
                'read' => false,
                'created_at' => $row->created_at,
                'user_id' => $row->user_id,
            ]);
        }

        /*
         * Merch Sales
         */
        $rows = MerchSale::select(
            'users1.name as user_name',
            'users2.name as buyer_name',
            'merch_sales.*',
        )
            ->join('users as users1', 'users1.id', '=', 'merch_sales.user_id')
            ->join('users as users2', 'users2.id', '=', 'merch_sales.buyer_id')
            ->limit(10)
            ->get();


        foreach ($rows as $row) {
            $message = "{$row->buyer_name} bought {$row->amount} fancy {$row->item_name} from you for {$row->price} USD! ";
            Event::create([
                'message' => $message,
                'read' => false,
                'created_at' => $row->created_at,
                'user_id' => $row->user_id,
            ]);
        }
    }
}
