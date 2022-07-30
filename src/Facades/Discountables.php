<?php

namespace AscentCreative\Offer\Facades;

use Illuminate\Support\Facades\Facade;

class Discountables extends Facade 
{
    protected static function getFacadeAccessor()
    {
        return 'offer:discountables';
    }
}