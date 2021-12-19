<?php
Route::group(array('module' => 'Admin', 'prefix' => 'admin', 'middleware' => ['web', 'admin'], 'namespace' => 'App\Modules\Admin\Controllers'), function() {

//    Route::get('/', 'AdminController@login');
//    Route::get('/login', 'AdminController@login');
    Route::get('/listPhysicians', 'AdminController@listPhysicians');
    Route::get('/listPatients', 'AdminController@listPatients');
//        --- start  showing published question set ----
    Route::get('/manageLibrary', 'AdminController@manageLibrary');
    Route::get('/publishedQuestions', 'QuestionSetController@listpublishedQuestions');
    //        --- end  showing published question set ----
    Route::get('/patients-list', 'QuestionSetController@patientsList');
    Route::get('/physicians-list', 'QuestionSetController@physiciansList');
    
    
    
    // Route::get('/physicians-list', 'QuestionSetController@physiciansListtest');



    Route::get('/adminEdit/{id}', 'QuestionSetController@editLibrary_Removed')->where('id', '[0-9]+');
    Route::post('/setFlags', 'QuestionSetController@updateFlagSettings');
    Route::post('/set-menu-settings', 'AdminController@updateMenuSettings');
    // Route::get('/editLibrary/{id}', 'QuestionSetController@editLibrary')->where('id', '[0-9]+');
    Route::get('/editLibrary/{id}', 'QuestionSetController@editLibrary');
    // Route::get('/patientProfileView/{id}', 'AdminController@patientProfileView')->where('id', '[0-9]+');
    Route::get('/patientProfileView/{id}', 'AdminController@patientProfileView');
   Route::get('/physicianProfileView/{id}', 'AdminController@physicianProfileView');
//    Route::get('/physicianProfileView', 'AdminController@physicianProfileView');
    // Route::get('/physicianProfileView/{id}', 'AdminController@physicianProfileView')->where('id', '[0-9]+');
    
    Route::get('cancel/{id}/{plan}', [
        'as' => 'admin.subscription.cancel',
        'uses' => 'AdminController@cancelSubscription'
    ]);

    Route::post('/uploadBgImage', 'QuestionSetController@uploadBgImage');
});
