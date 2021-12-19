<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;

class MyResetPassword extends Notification {

    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
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
        return (new MailMessage)
                        ->subject(config('app.name') . ' - Reset Password')
                        ->greeting('Hello,')
                        ->line('You are receiving this email because we received a password reset request for your account.')
                        ->line('To reset your password, click the following button.')
                        ->action('Reset Password', url('password/reset', $this->token))
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
        $user = DB::table('users')
                ->join('password_resets', function ($join) use ($token) {
                    $join->on('users.email', '=', 'password_resets.email')
                    ->where('password_resets.token', 'like', $token);
                })
                ->first();
        return $user;
    }

}
