<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrederCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        // $store=$event->order->store;

        // singl user
        $user = User::where('store_id', '=', $event->order->store_id)->first();
        // dd($user->name);
        $user->notify(new OrederCreatedNotification($event->order));


        // multiable user
        // $users=User::where('store_id','=',$event->order->store_id)->get();
        // Notification::send($users,new OrederCreatedNotification($event->order));
    }
}
