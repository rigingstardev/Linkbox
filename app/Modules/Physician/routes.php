<?php
Route::group(array('module' => 'Physician', 'prefix' => 'physician', 'middleware' => ['web', 'guest'], 'namespace' => 'App\Modules\Physician\Controllers'), function() {
    Route::get('/register', 'PhysicianController@register');
    Route::get('/doximity', 'DoximityController@getAuthorization');
    //Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');
});
Route::group(array('module' => 'Physician', 'prefix' => 'physician', 'middleware' => ['web','auth', 'valid.session'], 'namespace' => 'App\Modules\Physician\Controllers'), function() {

    Route::group(['middleware' => 'subscribed'], function () {
        Route::get('/createQuestionSet', 'QuestionSetController@createQuestionSet')->middleware('access:questionset_create', 'termscondition');
        Route::post('/postQuestionSet', 'QuestionSetController@insertQuestionSetStepOne');
        Route::get('createQuestionSetNext/{id}', 'QuestionSetController@createQuestionSetNext')->where('id', '[0-9]+');
        Route::post('/editQuestionSet', 'QuestionSetController@editQuestionSetStepOne')->middleware('access:questionset_edit');
       
    });
    Route::get('dashboard', 'PhysicianController@dashboard')->middleware('subscribed');
    //Route::get('home', 'PhysicianController@home')->middleware('subscribed');
    Route::get('home', 'PhysicianController@home');

    Route::get('/{physicianid}/sidebar', [
        'as' => 'adminstaffsidebar.sidebar',
        'uses' => 'AdminStaffController@sidebar'
    ]);

    Route::get('/get-question-sets', 'PhysicianController@getQuestionSets');
    Route::post('/postLogin', 'PhysicianController@postLogin');
    // start listing preview and send
    Route::get('/questionSet', 'PhysicianController@questionSet')->middleware('access:questionset_list', 'termscondition');
    Route::get('/questionSetPreview/{id}', 'PhysicianController@questionSetPreview')->middleware('access:questionset_list')->where('id', '[0-9]+');
    Route::get('/questionSetPreview/{id}/*', 'PhysicianController@questionSetPreview')->middleware('access:questionset_list')->where('id', '[0-9]+');
    Route::get('/questionSetPreview/{id}/edit', 'PhysicianController@questionSetPreview')->middleware('access:questionset_list');
    Route::get('/questionSetPreview/{id}/create-set', 'PhysicianController@questionSetPreview')->middleware('access:""');
    // Route::get('/questionSetPreview/{id}/create-set', 'PhysicianController@questionSetPreview')->middleware('access:""')->where('id', '[0-9]+');
    Route::get('/questionSetPreview/{id}/published-list', 'PhysicianController@questionSetPreview')->middleware('access:questionset_list');
    // Route::get('/questionSetPreview/{id}/published-list', 'PhysicianController@questionSetPreview')->middleware('access:questionset_list')->where('id', '[0-9]+');

    Route::get('/sendQuestionSet/{id}', 'PhysicianController@sendQuestionSet')->middleware('access:questionset_send');
    // Route::get('/sendQuestionSet/{id}', 'PhysicianController@sendQuestionSet')->middleware('access:questionset_send')->where('id', '[0-9]+');
    Route::post('/postSendQuestionSet', 'PhysicianController@postSendQuestionSet');
    Route::post('/checkSendQuestionSet', 'PhysicianController@validateSendQuestionSet');
    Route::post('/resendQuestionSet', 'PhysicianController@resendQuestionSet');
    Route::post('/delete-question-set', 'PhysicianController@deleteQuestionSet');

    // end listing preview and send
    // start create, edit and flag question set

    Route::post('/editCategory', 'QuestionSetController@editCategoryList')->middleware('access:""');
    Route::post('/set-flags', 'QuestionSetController@setQuestionFlags')->middleware('visibility');
    Route::post('/edit-question-settings', 'PhysicianController@editQustionSettings');
    Route::post('/update-question-settings', 'QuestionSetController@updateQustionSettings');
    Route::post('/show-answer-option', 'QuestionSetController@showAnswerOption');
    Route::post('/buiild-this-question-set', 'QuestionSetController@buiildThisQuestionSet');
    Route::get('/get-next-question-on-yesno', 'QuestionSetController@getNextQuestionOnYesNo');

    Route::post('/edit/question/defaultOutput', [
        'as' => 'question.defaultoutput.edit',
        'uses' => 'QuestionSetController@editQuestionNarrativeOutput'
    ]);

    // end create, edit and flag question set
    Route::post('/set-menu-settings', 'PhysicianController@updateMenuSettings');

    Route::get('/question-set-detail/{id}/edit', 'QuestionSetController@questionSetDetail')->where('id', '[0-9]+');
    Route::get('/question-set-detail/{id}/show', 'QuestionSetController@questionSetDetailShow')->where('id', '[0-9]+');
    Route::get('/question-set-detail/{id}', 'QuestionSetController@questionSetDetail');
    //Route::get('/listPatients', 'PhysicianController@listPatients')->middleware('access:patient_list');

    // Route::get('/use-the-question-set/{id}', 'QuestionSetController@useTheQuestionSet')->where('id', '[0-9]+');
    Route::get('/use-the-question-set/{id}', 'QuestionSetController@useTheQuestionSet');

    Route::get('/receipients-list', 'QuestionSetController@getReceipientsList');
    //Route::get('/patientDetails', 'PhysicianController@patientDetails');
    Route::get('/viewMedicalRecord/{id}', 'PhysicianController@viewMedicalRecord');
    Route::get('/patientQuestionSetDetail', 'PhysicianController@patientQuestionSetDetail');
    Route::post('/postPatientQuestionSetDetail', 'PhysicianController@postPatientQuestionSetDetail');

    Route::get('/listNotifications', 'PhysicianController@listNotifications')->middleware('termscondition');
    Route::get('/notifications', 'PhysicianController@getNotificationsList')->middleware('termscondition');
    Route::post('/update-notification', 'PhysicianController@updateNotification');
    Route::post('/get-notification-count', 'PhysicianController@getNotificationsList');
    Route::get('/notifications/{id}/delete', [
        'as' => 'physician.notifications.delete',
        'uses' => 'PhysicianController@deleteNotification'
    ])->where('id', '[0-9]+');

    Route::get('/profile', 'PhysicianController@profile')->middleware('termscondition');
    Route::post('/postProfile', 'PhysicianController@postProfile');

    // Route::get('/subscription', 'PhysicianController@subscription');
    //Route::get('/subscriptionDetails', 'PhysicianController@subscriptionDetails');

    Route::post('/postChangePwd', 'PhysicianController@postChangePwd');
    Route::post('/editProfileImage', 'PhysicianController@editProfileImage');
    
    /* Admin Staff Routes */
    Route::get('/adminstaff/listPopup', [
        'as' => 'physician.administratorstaff.popupList',
        'uses' => 'AdminStaffController@getPopupList'
    ]);

    Route::post('/adminstaff/addExistingAdministrators', [
        'as' => 'physician.administratorstaff.addstaff',
        'uses' => 'AdminStaffController@postAddStaffInPhysician'
    ]);
    
    Route::get('/staff-dashboard', [
        'as' => 'physician.administratorstaff.staff-dashboard',
        'uses' => 'AdminStaffController@dashboard'
    ]);


    Route::get('/adminstaff/new', [
        'as' => 'physician.adminstaff.new',
        'uses' => 'AdminStaffController@getNew'
    ])->middleware('access:admin_staff_create');

    Route::post('/adminstaff/create', [
        'as' => 'physician.adminstaff.create',
        'uses' => 'AdminStaffController@postCreate'
    ]);

    Route::get('/adminstaff/edit/{user_id}', [
        'as' => 'physician.adminstaff.edit',
        'uses' => 'AdminStaffController@getEdit'
    ])->middleware(['access:admin_staff_edit','hasPrevilege:edit_staff']);

    Route::post('/adminstaff/update', [
        'as' => 'physician.adminstaff.update',
        'uses' => 'AdminStaffController@postUpdate'
    ]);

    //->middleware(['access:admin_staff_edit','hasPrevilege:update_staff']);

    Route::get('/adminstaff/delete/{user_id}', [
        'as' => 'physician.adminstaff.delete',
        'uses' => 'AdminStaffController@getDelete'
    ])->middleware(['access:admin_staff_delete','hasPrevilege:delete_staff']);

    Route::get('/adminstaff', [
        'as' => 'physician.adminstaff.index',
        'uses' => 'AdminStaffController@index'
    ])->middleware('access:admin_staff_list', 'termscondition');

    Route::get('/adminstaff/list', [
        'as' => 'physician.adminstaff.list',
        'uses' => 'AdminStaffController@getList'
    ])->middleware('access:admin_staff_list');
    /* Admin Staff Routes Ends */
    /* Patient Routes */
    Route::get('/patients', [
        'as' => 'physician.patient.index',
        'uses' => 'PatientController@index'
    ])->middleware('access:patient_list', 'termscondition');

    Route::get('/patients/list', [
        'as' => 'physician.patient.list',
        'uses' => 'PatientController@getList'
    ]);

    Route::get('/patients/{id}/details', [
        'as' => 'physician.patient.details',
        'uses' => 'PatientController@getPatientDetails'
    ]);

    //->middleware('userExists');

    Route::get('/patients/{id}/questions', [
        'as' => 'physician.patient.questions',
        'uses' => 'PatientController@getQuestionSetList'
    ])->where('id', '[0-9]+');
    Route::post('/questions/{id}/answers', [
        'as' => 'physician.question.answers',
        'uses' => 'PatientController@postAnswer'
    ]);
    Route::get('/patients/{id}/summary', [
        'as' => 'physician.patient.summary',
        'uses' => 'PatientController@getSummaryReport'
    ])->middleware('reportPermission');

    Route::get('/patients/{id}/pdfStream', [
        'as' => 'physician.summary.pdf',
        'uses' => 'PatientController@pdfStream'
    ])->where('id', '[0-9]+')->middleware('reportPermission');

    Route::get('/patients/{id}/fullPdfStream', [
        'as' => 'physician.full.pdf',
        'uses' => 'PatientController@fullPdfStream'
    ])->where('id', '[0-9]+')->middleware('reportPermission');

    Route::post('/send-summary-report', 'PatientController@sendSummaryReport');
    Route::post('/checkClinicalQuestion', 'PatientController@checkClinicalQuestions');

    Route::get('/patients/{id}/questionset', [
        'as' => 'physician.patient.questionsetdetail',
        'uses' => 'PatientController@getQuestionSetDetail'
    ]);
    Route::get('/patients/{id}/evaluation', [
        'as' => 'physician.patient.evaluation',
        'uses' => 'PatientController@getEvaluationReport'
    ])->middleware('reportPermission');

    Route::get('/patients/listPopup', [
        'as' => 'physician.patient.popupList',
        'uses' => 'PatientController@getPopupList'
    ]);

    // Test Previwe Question Set
    Route::post('question-set-preview-detail', 'QuestionSetController@getQuestionSetFirstPhase');
    Route::get('/question-set-test-preview-detail/{id}/show', 'QuestionSetController@testPreviewQuestionSetDetail');
    Route::post('/questions/{id}/answersSetPreview', [
        'as' => 'physician.question.set_preview_answers',
        'uses' => 'PatientController@postSetPreviewAnswer'
    ]);

    /* Patient Routes Ends */
    /* Subscription Routes */

    Route::get('/subscription', [
        'as' => 'physician.subscription.index',
        'uses' => 'SubscriptionController@index'
    ]);
    Route::post('/subscribe', [
        'as' => 'physician.subscription.create',
        'uses' => 'SubscriptionController@postCreate'
    ]);
    Route::post('/upgrade', [
        'as' => 'physician.subscription.upgrade',
        'uses' => 'SubscriptionController@postUpgrade'
    ]);
    Route::get('/cancel/{plan}', [
        'as' => 'physician.subscription.cancel',
        'uses' => 'SubscriptionController@getCancel'
    ]);
    /* Subscription Routes Ends */

    Route::get('/allergyList', 'PatientController@getAllergyList');
    Route::get('/medicationsList', 'PatientController@getMedicationsList');
    Route::get('/getPastMedHistory', 'PatientController@getPastMedHistory');
    Route::get('/getSurgicalHistory', 'PatientController@getSurgicalHistory');
    Route::get('/getFamilyHistory', 'PatientController@getFamilyHistory');

    /* medical history */

    Route::post('/changeStatus', 'PhysicianController@updateAgreementStatus');
});

Route::group(['namespace' => 'App\Http\Controllers\Webhooks', 'prefix' => 'webhooks'], function() {
    // protects the route from get posts
    Route::get('/stripe', function() {
        return Redirect::route('/home');
    });
    Route::post('/stripe', ['uses' => 'StripeController@handleWebhook']);
});

Route::post(
    'stripe/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);
