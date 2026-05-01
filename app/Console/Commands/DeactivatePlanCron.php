<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\PlanSubscription;
use Carbon\Carbon;

class DeactivatePlanCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deactivateplan:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Desactiva los Planes Vencidos';

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
        
        Log::info("Cron is working.. Deactivating Plans Start");
        $now = Carbon::now();
        $subscriptions = PlanSubscription::where('active', 1)->get();
        Log::info("Cron is working.. Active subscrtiptions: " . $subscriptions->count());
        
        foreach($subscriptions as $subscription) { 
            Log::info("Cron is working.. Comparing Dates: " . $subscription->enddate);
            $endDate = Carbon::parse($subscription->enddate);
            
            Log::info("Cron is working.. Comparing Dates: " . $endDate->lte( $now));
            
            if ($endDate->lte( $now) ){
                $subscription->active = 0;
                $subscription->save();
                
                Log::info("Plan deactivated: " . $subscription->getPlanName() . " From user: " . $subscription->getUserEmail() );
            }
        }
        
        Log::info("Cron is working.. Deactivating Plans End");
        return 0;
    }
}
