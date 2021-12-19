<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
//    public function __destruct() {
////        dd(session()->getId()."    ".Auth::guard('patient')->User()->id);
//        \App\Sessions::where('id', session()->getId())->update(['user_id' => Auth::guard('patient')->User()->id]);
//    }
}
