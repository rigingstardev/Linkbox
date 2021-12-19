<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StripePaymentSuccess extends Notification
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
					->subject(config('app.name') .' - Payment Received for '. $this->data['plan'].' Plan')
					->greeting('Hello ' . $this->data['name'] . ',')					
					->line('We have received an amount of '.$this->data['amount'].' towards your payment for the '.$this->data['plan'].' plan intended for '.$this->data['start_date'].' to ' .$this->data['end_date']);					
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
