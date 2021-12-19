<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Modules\Physician\Models\Questions;
use App\Modules\Patient\Models\Patient;

class userExists {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $patientDetails = Patient::where('id', $request->id)->first();
        if (!$patientDetails) {
            return response()->view('errors.404', [], 404);
        }
        return $next($request);
    }

}
