<?php

namespace App\Providers;

use App\Events\NewChatMessage;
use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use App\Listeners\NewChatMessageNotification;
use App\Listeners\UserCacheListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreated::class => [
            UserCacheListener::class,
        ],
        UserUpdated::class => [
            UserCacheListener::class,
        ],
        UserDeleted::class => [
            UserCacheListener::class,
        ],
        NewChatMessage::class =>[
            NewChatMessageNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
