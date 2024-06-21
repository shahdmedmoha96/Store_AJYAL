<?php

namespace App\View\Components\Dashboard;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class notification_menu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $notifications;
    public $newCount;
    public function __construct()
    {
        $user = Auth::user();
        $this->notifications = $user->notifications()->take(10)->get();
        $this->newCount = $user->unreadnNotifications()->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.notification_menu');
    }
}
