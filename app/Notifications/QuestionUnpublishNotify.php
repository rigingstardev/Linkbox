<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class QuestionUnpublishNotify extends Notification {

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
        return (new MailMessage)
                        ->subject(config('app.name') . ' - Question Set Unpublished')
                        ->greeting('Hello ' . $this->data['name'] . ',')
                        ->line('Your question set "'.$this->data['question'].'" has been unpublished by the admin due to the following reason.')
                        ->line('"'.$this->data['reason'].'"')
                        ->line('Please contact admin at '.env('ADMIN_EMAIL').' for further details.');
//                        ->action('Visit Site', url('/'));
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
