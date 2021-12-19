<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();
Auth::shouldUse('admin');
    // dd($users);

    return view('Admin::list_physicians');
})->name('home');

