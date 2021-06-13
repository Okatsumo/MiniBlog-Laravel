<?php

namespace App\Notifications;

use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $user;
    private $userIp;
    private $userAgent;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $userIp, $userAgent)
    {
        $this->user = $user;
        $this->userIp = $userIp;
        $this->userAgent = $userAgent;
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
                    ->line($this->user->name . ', с Вашей учетной записи недавно была произведена попытка авторизации')
                    ->line("Если авторизоваться пытались не Вы, пожалуйста, как можно скорее смените пароль в настройках своей учетной записи")
                    ->action('Перейти в настройки учетной записи', url('/user/' . $this->user->user_id))
                    ->line("ip: " . $this->userIp)
                    ->line("Устройство: " . $this->userAgent);
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
