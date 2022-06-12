<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Services\UserService;

class UpdateRankingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rankings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public UserService $userService;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = collect($this->userService->get('users'));
        $ambassadors = $users->filter(fn ($user) => $user['is_admin'] === 0);

        $bar = $this->output->createProgressBar($ambassadors->count());
        $bar->start();

        $ambassadors->each(function ($user) use ($bar) {
            $orders = Order::where('user_id', $user->id);
            $revenue = $orders->sum(fn (Order $order) => $order->total);

            Redis::zodd('rankings', (int)$revenue, "{$user->name} {$user->last_name}");
            $bar->advance();
        });

        $bar->finish();
    }
}
