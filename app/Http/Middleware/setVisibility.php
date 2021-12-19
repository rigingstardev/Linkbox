<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Modules\Physician\Models\Questions;

class setVisibility {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $requestData = $request->all();
        $recordExists = Questions::where('id', $requestData['qid'])->where('user_id', Auth::user()->id)->first();
        if (!$recordExists) {
            return response()->json(['error' => 1, 'error_code' => 401, 'message' => 'Unauthorized']);
            exit;
        }
        return $next($request);
    }

}
