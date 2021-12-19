<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;

/**
 * EmailHelper - Helper class used for sending emails
 *
 */
class EmailHelper {

    /**
     * sendEmail
     *
     * Method uder for sending emails to users
     * 
     */
    public static function sendEmail($user, $email) {
        return Mail::to($user->email)->send($email);
    }

}
