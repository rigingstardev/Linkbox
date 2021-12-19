<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;

class PatientResetPassword extends Notification {

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @param $token
     */
    public function __construct($token) {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        $userDetails = $this->getUserFromToken($this->token);
        // ->greeting('Hello ' . $userDetails->first_name ." ". $userDetails->last_name. ',')
        return (new MailMessage)
            ->subject(config('app.name') . ' - Reset Password')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->line('To reset your password, click the following button.')
            ->action('Reset Password', url('patient/password/reset', $this->token))
            ->line('If you did not request a password reset, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
                //
        ];
    }

    /**
     * Get the username from password reset token.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function getUserFromToken($token) {
        $user = DB::table('patients')
            ->join('patient_password_resets', function ($join) use ($token) {
                $join->on('patients.email', '=', 'patient_password_resets.email')
                ->where('patient_password_resets.token', 'like', $token);
            })
            ->first();
        return $user;
    }

}
