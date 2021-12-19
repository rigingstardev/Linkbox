<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StaffNotify extends Notification {

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
        if ($this->data['action'] == 'CREATE') {
            return (new MailMessage)
                            ->subject(config('app.name') . ' - Administrative Staff Account')
                            ->greeting('Hello ' . $this->data['name'] . ',')
                            ->line('An account has been created for you in the '.config('app.name').' application with the following credentials:')
                            ->line('Email : ' . $this->data['email'])
                            ->line('Password : ' . $this->data['password'])
                            ->line('Please visit the site to login.')
                            ->action('Visit Site', url('/'));
        }
        if ($this->data['action'] == 'UPDATE') {
            return (new MailMessage)
                            ->subject(config('app.name') . ' - Administrative Staff Account Modified')
                            ->greeting('Hello ' . $this->data['name'] . ',')
                            ->line('Your account credentials for the '.config('app.name').' application have been changed as follows:')
                            ->line('Email : ' . $this->data['email'])
                            ->line('Password : ' . $this->data['password'])
                            ->line('Please visit the site for further details.')
                            ->action('Visit Site', url('/'));
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
