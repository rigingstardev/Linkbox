<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewSubscription extends Notification
{
    use Queueable;
	protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($params)
    {
       $this->data = $params;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)                   
					->subject(config('app.name') .' - '. $this->data['plan'].' Subscription Details')
					->greeting('Hello ' . $this->data['name'] . ',')	
                
                
                
					->line('The subscription charge of '.$this->data['amount'].' has been deducted for the '.$this->data['plan'].' plan intended for '.$this->data['start_date'] .' to ' .$this->data['end_date'].'.')
					->line('For more details, please contact the admin at '.env('ADMIN_EMAIL'). '.');					
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
