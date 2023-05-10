<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Messages\ShortMessage;

class TextMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected int $identity;
    protected string $recipient;
    protected string $content;

    /**
     * The function takes an array of data, and assigns the values of the array to the properties of
     * the class
     * 
     * @param array data An array of data that will be used to populate the message.
     */
    public function __construct(array $data)
    {
        $this->identity = $data['id'];
        $this->recipient = $data['telephone'];
        $this->content = $data['content'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */

    /**
     * The via() method determines how the notification will be delivered
     * 
     * @param notifiable The entity that is receiving the notification. In this case, it will be the
     * App\User model, since we specified it in the via() method.
     */
    public function via($notifiable)
    {
        // return ['mail'];
    }

    /**
     * > The `toBroadcastingChannel` function is used to convert the `Notification` object to a
     * `ShortMessage` object
     * 
     * @param notifiable The entity that is sending the notification.
     * 
     * @return ShortMessage A ShortMessage object.
     */
    public function toBroadcastingChannel($notifiable): ShortMessage
    {
        return (new ShortMessage)
            ->setIdentity($this->identity)
            ->setContent($this->content)
            ->setRecipient(phoneNumberPrefix($this->recipient));
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
