<?php

namespace AscentCreative\Offer\Rules;

use AscentCreative\Offer\Rules\AbstractRule as Rule;
use AscentCreative\Offer\Models\Offer;

class PercentDiscount extends Rule {

    static function apply(Offer $offer, $basket) {
       
        // // $cfg = json_decode($offer->config);
        $cfg = (object) $offer->config;

        if($cfg->against == 'basket' && $basket->items()->count() > 0) {
            $application = uniqid();
            $basket->offers()->attach($offer, ['value'=> ($basket->itemTotal * $cfg->percentage / 100)*-1 ]);
        }

        if($cfg->against == 'items') {
            $items = $offer->applicableItems($basket);
            foreach($items as $item) {

                $application = uniqid();
                // $item->offers()->attach($offer, ['value'=>($item->itemPrice * $cfg->percentage / 100) * -1, 'application_id' => $application]);
                $item->itemPrice = $item->itemPrice * (1 - ($cfg->percentage / 100));
                $item->offer_id = $offer->id;

            }
        }

    }


    static function remove(Offer $offer, $target) {
        // $target->itemPrice = $offer->pivot->reset_data['original_price'];
        // $target->save();
    }


}