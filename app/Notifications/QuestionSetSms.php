<?php namespace App\Notifications;

use Twilio\Rest\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Illuminate\Support\Facades\Auth;

class QuestionSetSms extends Notification
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

        return [TwilioChannel::class];
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

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

    public function toTwilio($notifiable)
    {
        // dd($notifiable);
        foreach ($recipients as $recipient) {
            $this->sendMessage($validatedData["body"], $recipient);
        }
//        if ($this->data['user_exists'] == TRUE) {
//            $name = ',';
//            $link_content = '';
//            $link_content = 'Login to  using the link ' . url('/');
//            if ($this->data['name'] !== "-") {
//                $name = ' ' . $this->data['name'] . ',';
//                $link_content = 'Register in  using the link ' . url('/patient/register/' . $this->data['uuid']);
//            }
//        } 

        // return (new TwilioSmsMessage())
        //         ->content('Dr. ' . ucwords(Auth::user()->name) . ' has sent you a few questions to answer prior to your office visit.  ' . $this->data['customMessage'] . ' Please visit site ' . url('/') . ' for further details. ');

    }

    
}
