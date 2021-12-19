<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionReminder;
use Illuminate\Support\Facades\Log;

class SendSubscriptionEmails extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:subscription-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify the users when their subscription is about to expire.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $date = \Carbon\Carbon::now()->addDays(3)->toDateString();
        $users = DB::table('users')
                ->select('id', 'name', 'email')
                ->where('user_role', 'D')
                ->where('is_account_active', 'Y')
                ->where(DB::raw('DATE(subscription_ends_at)'), $date)
                ->get();
//        dd($users);
        Log::useDailyFiles(storage_path().'/logs/email-failed.log');
        foreach ($users as $user) {
            try {
                $user->expiry_date = date('m/d/Y', strtotime($date));
                Mail::to($user->email)->send(new SubscriptionReminder($user));
            } catch (Exception $e) {
                Log::info('Email sending failed', ['user_type' => 'Physician','id' => $user->id,'email' => $user->email]);
                continue;
            }
        }
        $this->info("Cron executed at " . date('Y-m-d H:i:s'));
    }

}
