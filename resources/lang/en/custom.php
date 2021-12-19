<?php
return [

    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class. Some of these rules have multiple versions such
      | as the size rules. Feel free to tweak each of these messages here.
      |
     */

    'dnInsertFailed' => 'An error occurred while saving the data. Please try again.',
    'dnInsertSuccess' => '',
    'select_any_category' => 'Select at least one category.',
    'delete_question_category' => 'Are you sure you want to delete this question category?',
    'copy_question_category' => 'Are you sure you want to copy this question?',
    'copy_question_category_success' => 'The question has been copied successfully.',
    'delete_question_category_success' => 'The question has been deleted.',
    'build_question_confirm' => 'Are you sure you want to build this question set?',
    'no_questions_found' => 'No question sets found.',
    'question_set_cannot_be_empty' => 'The question set should contain at least one question.',
    'specify_option' => 'Specify Option/Choice.',
    'specify_option_only' => 'Select at least one option.',
    'disabled_question_category_success' => 'The question has been disabled successfully.',
    'enabled_question_category_success' => 'The question has been enabled successfully.',
    'set_as_clinical_question' => 'This question has been set as Clinical Question.',
    'unset_clinical_question' => 'Clinical Question settings have been removed successfully.',
    'category_max_length' => 'Category should not contain more than 100 characters.',
    'description_max' => '1500',
    'description_max_length' => 'Description should not contain more than 1500 characters.',
    'text_option_max_length' => 'Option/Choice should not contain more than 255 characters.',
    'change_question_visibility' => 'Are you sure you want to change the status of the question set as ',
//    'question_visibility_changed' => 'Question set visiblity updated to ',
    'alert_another_question_open_for_edit' => 'You are allowed to edit only one question at a time. To edit another question either save or cancel the updates made to the opened question.',
    'email_verified' => 'Your email address has been verified successfully.',
    'password_reset_success' => 'Your password has been reset successfully.',
    'no_data' => 'No records found.',
    'specify_recipient' => 'Select at least one recipient.',
    'account_not_active' => 'Your account is not yet active. Please click the account activation link received in the email.',
    'profile_update_success' => 'Your profile details have been updated successfully.',
    'profile_image_update_success' => 'Your profile image has been updated successfully.',
    'password_change_success' => 'Your password has been updated successfully.',
    'old_password_mismatch' => 'The specified old password is incorrect.',
     'specify_other_question' => 'Specify Question.',
    'other_question_max_length' => 'Question can contain a maximum of 255 characters.',
    'other_question' => 'Is there anything else you would like to add about the [CC]?', // also set in db table - category_questions
    'question_status_change_success' => 'The status of the question set has been changed to ',
    'no_notifications_found' => 'No data available to display.',
    'specify_phone' => 'Specify Phone number.',
    'specify_email' => 'Specify Email.',
    'phone_min' => 'The phone number must contain at least 10 characters.', // modified for link box
    'phone_max' => 'The phone number must not exceed 15 characters.', // modified for link box
    'phone_regex_format' => 'Specify a valid phone number.', // modified for link box
    'mail_sent_success' => 'The mail has been sent successfully.', // modified for link box
    'phone_num_format_text' => 'Format +14155552671',
];
