<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('patient')->user();
    Auth::shouldUse('patient');
    //dd($users);

    return redirect('/patient');
})->name('home');

