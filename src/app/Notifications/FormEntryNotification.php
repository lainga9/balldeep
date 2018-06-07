<?php

namespace Lainga9\BallDeep\app\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Lainga9\BallDeep\app\FormEntry;
use Lainga9\BallDeep\app\FormNotification;

class FormEntryNotification extends Notification
{
    use Queueable;

    /**
     * The entry which was created
     * 
     * @var FormEntry
     */
    protected $entry;

    /**
     * The notification 
     * 
     * @var FormNotification
     */
    protected $notification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(FormEntry $entry, FormNotification $notification)
    {
        $this->entry = $entry;
        $this->notification = $notification;
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
        $message = (new MailMessage);

        $message->subject($this->notification->subject($this->entry));

        $message->view('balldeep::emails.forms.entry', [
            'content' => $this->notification->content($this->entry)
        ]);

        return $message;
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
