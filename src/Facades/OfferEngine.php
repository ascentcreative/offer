<?php

namespace AscentCreative\Offer\Facades;

use Illuminate\Support\Facades\Facade;

class OfferEngine extends Facade 
{
    protected static function getFacadeAccessor()
    {
        return 'offer:offer_engine';
    }
}