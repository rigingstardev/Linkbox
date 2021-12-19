<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Physician\Requests\DemoRequest;
use App\Helpers\AutoSuggestHelper;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return view('home');
        return redirect('/physician/home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function requestDemo(RequestDemoRequest $request)
    {
        return redirect('/');
    }

    public function autoComplete(Request $request)
    {
        return AutoSuggestHelper::autoSuggest($request->all());
    }
}
