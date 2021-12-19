<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\QuestionReceipients;

class postAnswer {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $recordExists = QuestionReceipients::where('id', $request->id)->where('patient_id', Auth::guard('patient')->User()->id)->first();
        if (!$recordExists) {
            return response()->json(['error' => 1, 'error_code' => 401, 'message' => 'Unauthorized']);
            exit;
        }
        $alreadyAnswered = QuestionReceipients::where('id', $request->id)->where('status', 'completed')->where('patient_id', Auth::guard('patient')->User()->id)->first();
        if ($alreadyAnswered) {
            return response()->json(['error' => 1, 'error_code' => 200, 'message' => 'Alredy Answered']);
            exit;
        }
        return $next($request);
    }

}
