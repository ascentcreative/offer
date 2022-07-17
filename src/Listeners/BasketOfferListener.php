<?php

namespace AscentCreative\Offer\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use AscentCreative\Checkout\Events\BasketUpdated;

use AscentCreative\Offer\Facades\OfferEngine;

/**
 * Listens for BasketUpdated events and updates the Stripe PaymentIntent for the session.
 */
class BasketOfferListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
       // echo "STRIPE CONSTR";
        //exit();
    }

    /**
     * Send API Request to Stripe to manage the payment intent
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BasketUpdated $event)
    {
        OfferEngine::process($event->basket);
    }
}
