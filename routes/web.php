<?php
/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */
Route::get('/', 'PatientAuth\LoginController@showLoginForm');

Route::get('/about', function () {
    return view('pages.about');
});

/**
 *  To clear the cache through browser
 */
Route::get('/clear-cache', function() {
  Artisan::call('config:clear');
  Artisan::call('config:clear');
  Artisan::call('view:clear');
  Artisan::call('route:clear');  
  return redirect('/home');
});

Route::get('/terms-of-use', function () {
  return view('pages.terms_of_use');
});
Route::get('/privacy-statement', function () {
  return view('pages.privacy_statement');
});
Route::get('/contact', function () {
    return view('pages.contact');
});
Route::post('contact_us', 'ContactUsController@index');

Route::get('/verify/{token}', 'Auth\RegisterController@verify');
Route::get('/patient/verify/{token}', 'PatientAuth\RegisterController@verify');
Route::get('/doximity', '\App\Modules\Physician\Controllers\DoximityController@authentication');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/autoComplete', 'HomeController@autoComplete');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminAuth\LoginController@showLoginForm');
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout');

//  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm');
//  Route::post('/register', 'AdminAuth\RegisterController@register');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'patient'], function () {
    Route::get('/login', 'PatientAuth\LoginController@showLoginForm');
    Route::post('/login', 'PatientAuth\LoginController@login');
    Route::post('/logout', 'PatientAuth\LoginController@logout');

    Route::get('/register', 'PatientAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'PatientAuth\RegisterController@register');

    Route::post('/password/email', 'PatientAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'PatientAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'PatientAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'PatientAuth\ResetPasswordController@showResetForm');
});



Route::group(['prefix' => 'administrator-staff'], function () {
  
    Route::get('/register', 'AdministratorStaffAuth\RegisterController@showRegistrationForm')->name("administarator-staff-register-form-show");
    Route::post('/register', 'AdministratorStaffAuth\RegisterController@register')->name("administarator-staff-register-form-submit");

});

// To check the user exists already
Route::post('/userexist', [
    'as' => 'userexist',
    'uses' => 'Auth\LoginController@checkUserExist'
  ]);
  Route::post('/loginRedirectUser', [
    'as' => 'loginRedirectUser',
    'uses' => 'Auth\LoginController@loginRedirectUser'
  ]);
  
  Route::get('/register-login', [
    'as' => 'register-login',
    'uses' => 'Auth\LoginController@redirectLoginRegister'
  ]);
  
  Route::post('/register-login', [
    'as' => 'register-login',
    'uses' => 'Auth\LoginController@redirectLoginRegister'
  ]);
  
  // Redirect to login Page after registration
  Route::get('physician/login', [
    'as' => 'physician-login',
    'uses' => 'Auth\LoginController@physicianLogin'
  ]);
  
  Route::get('patient/login', [
    'as' => 'patient-login',
    'uses' => 'Auth\LoginController@patientLogin'
  ]);
