<?php

namespace App\Console\Commands;

use App\Jobs\OrderCompleted;
use App\Models\Order;
use Illuminate\Console\Command;

class ProduceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'produce';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $order = Order::first();

        $array = $order->toArray();
        $array['ambassador_revenue'] = $order->ambassador_revenue;

        OrderCompleted::dispatch($array);
    }
}
