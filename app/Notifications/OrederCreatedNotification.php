<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrederCreatedNotification extends Notification
{
    use Queueable;
    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
        $channels = ['database'];
        if ($notifiable->notification_preferences['order_create']['sms'] ?? false) {
            $channels[] = 'vonage';
        }
        if ($notifiable->notification_preferences['order_create']['mail'] ?? false) {
            $channels[] = 'mail';
        }
        if ($notifiable->notification_preferences['order_create']['broadcast'] ?? false) {
            $channels[] = 'broadcast';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $addr = $this->order->billingAddresses;
        // dd($addr->first_name );
        return (new MailMessage)
            ->subject('New Order # ' . $this->order->number)
            ->from('notification@ajyal-store.ps', 'AJYAL Store')
            ->greeting("Hi {$notifiable->name},")
            ->line("New Order (#{$this->order->number}) created By{$addr->first_name}{ $addr->last_name}")
            ->action('View Order', url('/dashboard'))
            ->line('Thank you for using our application!');
    }
    public function toDatabase($notifiable)
    {
        $addr = $this->order->billingAddresses;
        // dd($addr->first_name );
        return [
            'body' => "New Order (#{$this->order->number}) created By{$addr->first_name}{ $addr->last_name}",
            'icon' => '',
            'url' => url('/dashboard'),


        ];
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
