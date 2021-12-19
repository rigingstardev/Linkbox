<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\LogHistory;
use Auth;

class LogSuccessfulLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        if ($event->user) {
            $user = $event->user;
            $currentSession = $this->request->session()->getId();
            $ip = $this->request->getClientIp();
            $userAgent = $this->request->userAgent();
            $logHistory = new LogHistory;
            $logout_time = Carbon::now();
            $isExist = LogHistory::where('ip_address',$ip)->where('user_agent',$userAgent)->update(['last_logout_in'=> $logout_time]);
        }
    }
}
