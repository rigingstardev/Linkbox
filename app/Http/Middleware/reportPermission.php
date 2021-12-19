<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\QuestionReceipients;
use Vinkla\Hashids\Facades\Hashids;

class reportPermission {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        //$request_id = Hashids::decode($request->id);
        //$request_id = $request_id[0];
        $request_id = $request->id;
        $recordExists = QuestionReceipients::where('id', $request_id)->where('physician_id', Auth::user()->getUserId())->first();
        if (!$recordExists) {
            return response()->view('errors.401', [], 401);
        }
        return $next($request);
    }

}
