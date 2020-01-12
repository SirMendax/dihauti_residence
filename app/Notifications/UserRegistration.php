<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class UserRegistration extends Notification
{
    use Queueable;

    /**
     * @var User
     */
    private User $newUser;

    /**
     * Create a new notification instance.
     *
     * @param User $newUser
     */
    public function __construct(User $newUser)
    {
        $this->newUser = $newUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
        //return ['database', 'broadcast'];
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
            'name' => $this->newUser->name,
            'email' => $this->newUser->email,
            'date' => $this->newUser->created_at,
        ];
    }

//    public function toBroadcast($notifiable)
//    {
//        return new BroadcastMessage([
//            'email' => $this->entry->email,
//            'date' => $this->entry->created_at,
//            'path' => $this->entry->path,
//        ]);
//    }
}
