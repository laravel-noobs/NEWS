<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\FeedbackChecked' => [
            'App\Listeners\FeedbackCheckedNotification'
        ],
        'App\Events\UserRegistered' => [
            'App\Listeners\UserEmailConfirmation'
        ],
        'App\Events\UserWasBanned' => [
            'App\Listeners\UserBannedNotification'
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
