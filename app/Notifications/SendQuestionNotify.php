<?php namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;

class SendQuestionNotify extends Notification
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
        if ($this->data['user_exists'] == TRUE) {
            $name = ',';
            if ($this->data['name'] !== "-") {
                $name = ' ' . $this->data['name'] . ',';
            }
            return (new MailMessage)
                    ->subject(config('app.name') . ' - Question set')
                    ->greeting('Hello' . $name)
                    ->line('Dr. ' . Auth::user()->name . ' has sent you a few questions to answer prior to your office visit.')
                ->line($this->data['customMessage'])
                    ->line('Please Visit Site for further Details.')
                    
                    ->action('Visit Site', url('/'));
        } else {
            return (new MailMessage)
                    ->subject(config('app.name') . ' - Question set')
                    ->line('Dr. ' . Auth::user()->name . ' has sent you a few questions to answer prior to your office visit.')
                ->line($this->data['customMessage'])
                    ->line('Please register with ' . config('app.name') . ' for more details.')
                    
                    ->action('Register', url('/patient/register/' . $this->data['uuid']));
        }
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
