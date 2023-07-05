<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Illuminate\Notifications\Messages\MailMessage;

class LoginNeedVerification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
       
        // return ['mail']; instead of mail we shall using TwilioChannel::class
        return [TwilioChannel::class];
    }
    //creating a class toTwilio
    public function toTwilio($notifiable){
        $loginCode = rand(111111, 999999);// help to generate 6 digit randome number

        $notifiable->update([

            'login_code' => $loginCode
        ]);
        return (new TwilioSmsMessage())->content("You Andrewber Login code is {$loginCode}, don't share this with any one ");
    }



    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
