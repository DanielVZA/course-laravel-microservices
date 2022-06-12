<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = \DB::connection('old_mysql')->table('orders')->get();

        foreach ($orders as $order) {
            Order::create([
                'id' => $order->id,
                'transaction_id' => $order->transaction_id,
                'user_id' => $order->user_id,
                'code' => $order->code,
                'ambassador_email' => $order->ambassador_email,
                'first_name' => $order->first_name,
                'last_name' => $order->last_name,
                'email' => $order->email,
                'address' => $order->address,
                'city' => $order->city,
                'country' => $order->country,
                'zip' => $order->zip,
                'complete' => $order->complete,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at
            ]);
        }
    }
}
