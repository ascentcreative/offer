<?php

namespace AscentCreative\Offer\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use AscentCreative\Checkout\Events\BasketUpdated;
use AscentCreative\Checkout\Events\OrderConfirmed;

use AscentCreative\Offer\Listeners\BasketOfferListener;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
     
    
        
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */

    public function register()
    {

        Event::listen(
                    BasketUpdated::class,
                    [BasketOfferListener::class, 'handle']
                );
        
    }
}
