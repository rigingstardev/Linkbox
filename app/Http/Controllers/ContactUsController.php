<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactUsRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;

class ContactUsController extends Controller
{
    public function index(ContactUsRequest $request) 
    {
        $request_data = $request->all();
        Mail::to(env('ADMIN_EMAIL'))->send(new ContactUs($request_data));
        return redirect('contact')->with('success', trans('custom.mail_sent_success'));
    }
}
