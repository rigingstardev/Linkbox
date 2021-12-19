<?php

Route::group(array('module' => 'Patient', 'prefix' => 'patient', 'middleware' => ['web', 'guest'], 'namespace' => 'App\Modules\Patient\Controllers'), function() {
    Route::get('/register', 'PatientController@register');
    Route::get('/register/{uuid}', 'PatientController@register');
});
Route::group(array('module' => 'Patient', 'prefix' => 'patient', 'middleware' => ['web', 'patient', 'valid.session'], 'namespace' => 'App\Modules\Patient\Controllers'), function() {
    Route::get('/', 'PatientController@dashboard');
    Route::get('/questions', 'QuestionController@questions');

    // Question Set Routes
    //QuestionSets
    Route::get('/questions', [
        'as' => 'patient.question.received',
        'uses' => 'QuestionController@questions'
    ])->middleware('termscondition');
    Route::get('/questions/lists', [
        'as' => 'patient.question.lists',
        'uses' => 'QuestionController@getList'
    ]);
    Route::get('/questions/{id}/brief', [
        'as' => 'patient.question.brief',
        'uses' => 'QuestionController@briefDetails'
    ]);
    Route::get('/questions/{id}/show', [
        'as' => 'patient.question.show',
        'uses' => 'QuestionController@show'
    ]);
    Route::post('/questions/{id}/answers', [
        'as' => 'patient.question.answers',
        'uses' => 'QuestionController@postAnswer'
    ]); //->middleware('postAnswer');
    Route::get('/patients/allergyList', [
        'as' => 'patient.allergies.list',
        'uses' => 'PatientController@getAllergyList'
    ]);
    Route::get('/patients/addPatientAllergy', [
        'as' => 'patient.add.allergies',
        'uses' => 'PatientController@addPatientAllergy'
    ]);
    Route::get('/patients/editPatientAllergy/{id}', [
        'as' => 'patient.edit.allergies',
        'uses' => 'PatientController@editPatientAllergy'
    ]);
    Route::get('/patients/deletePatientAllergy/{id}', [
        'as' => 'patient.delete.allergies',
        'uses' => 'PatientController@deletePatientAllergy'
    ]);
    Route::post('/patients/postPatientAllergy', [
        'as' => 'patient.post.allergies',
        'uses' => 'PatientController@postPatientAllergy'
    ]);

    Route::get('/patients/medicationsList', [
        'as' => 'patient.medications.list',
        'uses' => 'PatientController@getMedicationsList'
    ]);
    Route::get('/patients/addMedications', [
        'as' => 'patient.add.medications',
        'uses' => 'PatientController@addMedications'
    ]);
    Route::get('/patients/editMedications/{id}', [
        'as' => 'patient.edit.medications',
        'uses' => 'PatientController@editMedications'
    ]);
    Route::get('/patients/deleteMedications/{id}', [
        'as' => 'patient.delete.medications',
        'uses' => 'PatientController@deleteMedications'
    ]);
    Route::post('/patients/postMedications', [
        'as' => 'patient.post.medications',
        'uses' => 'PatientController@postMedications'
    ]);

    Route::get('/patients/getPastMedHistory', [
        'as' => 'patient.med_history.list',
        'uses' => 'PatientController@getPastMedHistory'
    ]);
    Route::get('/patients/addPastMedHistory', [
        'as' => 'patient.add.med_history',
        'uses' => 'PatientController@addPastMedHistory'
    ]);
    Route::get('/patients/editPastMedHistory/{id}', [
        'as' => 'patient.edit.med_history',
        'uses' => 'PatientController@editPastMedHistory'
    ]);
    Route::get('/patients/deletePastMedHistory/{id}', [
        'as' => 'patient.delete.med_history',
        'uses' => 'PatientController@deletePastMedHistory'
    ]);
    Route::post('/patients/postMedicalHistory', [
        'as' => 'patient.post.med_history',
        'uses' => 'PatientController@postMedicalHistory'
    ]);

    Route::get('/patients/getSurgicalHistory', [
        'as' => 'patient.surgical_history.list',
        'uses' => 'PatientController@getSurgicalHistory'
    ]);
    Route::get('/patients/addSurgicalHistory', [
        'as' => 'patient.add.surgical_history',
        'uses' => 'PatientController@addSurgicalHistory'
    ]);
    Route::get('/patients/editSurgicalHistory/{id}', [
        'as' => 'patient.edit.surgical_history',
        'uses' => 'PatientController@editSurgicalHistory'
    ]);
    Route::get('/patients/deleteSurgicalHistory/{id}', [
        'as' => 'patient.delete.surgical_history',
        'uses' => 'PatientController@deleteSurgicalHistory'
    ]);
    Route::post('/patients/postSurgicalHistory', [
        'as' => 'patient.post.surgical_history',
        'uses' => 'PatientController@postSurgicalHistory'
    ]);

    Route::get('/patients/getFamilyHistory', [
        'as' => 'patient.family_history.list',
        'uses' => 'PatientController@getFamilyHistory'
    ]);
    Route::get('/patients/addFamilyHistory', [
        'as' => 'patient.add.family_history',
        'uses' => 'PatientController@addFamilyHistory'
    ]);
    Route::get('/patients/editFamilyHistory/{id}', [
        'as' => 'patient.edit.family_history',
        'uses' => 'PatientController@editFamilyHistory'
    ]);
    Route::get('/patients/deleteFamilyHistory/{id}', [
        'as' => 'patient.delete.family_history',
        'uses' => 'PatientController@deleteFamilyHistory'
    ]);
    Route::post('/patients/postFamilyHistory', [
        'as' => 'patient.post.family_history',
        'uses' => 'PatientController@postFamilyHistory'
    ]);

    Route::post('/patients/postSocialHistory', [
        'as' => 'patient.post.social_history',
        'uses' => 'PatientController@postSocialHistory'
    ]);

    Route::get('/receivedQuestionSets', 'PatientController@receivedQuestionSets');
    Route::get('/questionSetBrief', 'PatientController@questionSetBrief');
    Route::get('/questionSetDetail', 'PatientController@questionSetDetail');
    Route::get('/profile', 'PatientController@profile');
    Route::post('/postProfile', 'PatientController@postProfile');
    Route::get('/medicalRecords', 'PatientController@medicalRecords')->middleware('termscondition');;
    Route::get('/notifications', 'PatientController@notifications')->middleware('termscondition');;
    Route::get('/list-notifications', 'PatientController@getNotificationsList');
    Route::post('/get-notification-count', 'PatientController@getNotificationsList');
    Route::post('/update-notification', 'PatientController@updateNotification');
    Route::get('/notifications/{id}/delete', [
        'as' => 'patient.notifications.delete',
        'uses' => 'PatientController@deleteNotification'
    ])->where('id', '[0-9]+');

//    Route::post('/list-notifications', 'PatientController@getNotificationsList');

    Route::post('/postChangePwd', 'PatientController@postChangePwd');
    Route::post('/editProfileImage', 'PatientController@editProfileImage');
    Route::post('/set-menu-settings', 'PatientController@updateMenuSettings');
        
    Route::post('/changeStatus', 'PatientController@updateAgreementStatus');
});
