<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserStatusChangeNotify extends Notification {

    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($params) {
        $this->data = $params;
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
        if ($this->data->status == 'Y') {
            return (new MailMessage)
                            ->subject(config('app.name') . ' - Account Activated')
                            ->greeting('Hello ' . $this->data['first_name'] . ',')
                            ->line('Your account has been activated.')
                            ->line('Please visit the site for further details.')
                            ->action('Visit Site', url('/'));
        } else if ($this->data->status == 'N') {
            return (new MailMessage)
                            ->subject(config('app.name') . ' - Account Inactivated')
                            ->greeting('Hello ' . $this->data['first_name'] . ',')
                            ->line('Your account has been inactivated.')
                            ->line('Please contact the admin at '.env('ADMIN_EMAIL').' for further details.');
//                            ->action('Visit Site', url('/'));
        }
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

}
