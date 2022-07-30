<?php
namespace AscentCreative\Offer\Traits;

use AscentCreative\Offer\Models\Offer;
use AscentCreative\Offer\Models\OfferUse;

trait Discountable {

    public static function bootDiscountable() {
   
        static::deleted(function($model) {
            
            $model->offers()->detach();
            
        });

    }

    public function offers() {
        return $this->morphToMany(Offer::class, 'target', 'offer_usage')
                ->withPivot('reset_data', 'value')
                ->using(OfferUse::class);
    }

    public function offer() {
        return $this->morphToMany(Offer::class, 'target', 'offer_usage')
                ->withPivot('reset_data', 'value')
                ->using(OfferUse::class)
                ->limit(1);
    }


    public function offerUse() {
        return $this->morphOne(OfferUse::class, 'target');
    }

    public function offerUses() {
        return $this->morphMany(OfferUse::class, 'target');
    }

    public function getEffectivePriceAttribute() {
        return $this->itemPrice + ($this->offerUses->first()->value ?? 0);
    }


}