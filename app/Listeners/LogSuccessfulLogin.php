<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;   
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use App\LogHistory;
use Auth;

class LogSuccessfulLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user; 
        
        $logHistory = new LogHistory([
        'ip_address' => $this->request->getClientIp(),
            'user_id' => $user->id,
            'session_id' => $this->request->session()->getId(),
            'user_agent' => $this->request->userAgent(),
            'last_logging_in' => Carbon::now(),
        ]);
        $logHistory->save();
        
    }
}
