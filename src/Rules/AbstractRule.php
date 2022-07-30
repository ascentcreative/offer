<?php
namespace AscentCreative\Offer\Rules;

use AscentCreative\Offer\Models\Offer;

abstract class AbstractRule {

    public function getDiscountables() {
    
    }

    abstract static function apply(Offer $offer, $basket);

    abstract static function remove(Offer $offer, $target);



}