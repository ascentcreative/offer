<?php

namespace AscentCreative\Offer\Rules;

use AscentCreative\Offer\Rules\AbstractRule as Rule;
use AscentCreative\Offer\Models\Offer;

class BuyXForY extends Rule {

    static function apply(Offer $offer, $basket) {
       
        // $cfg = json_decode($offer->config);
        $cfg = (object) $offer->config;

        $items = $offer->applicableItems($basket);

        // dd($items);

        // iterate the max number of times:
        $iterations = floor($items->count() / $cfg->quantity_required);

        // for each iteration
        $idxItem = 0;
        for($i = 0; $i < $iterations; $i++) {

            $application = uniqid();

            $prices = \AscentCreative\CMS\Util\SplitAndRound::processEqually($cfg->total, $cfg->quantity_required);

            // apply the offer to the specified number of items
            for($j = 0; $j < $cfg->quantity_required; $j++) {

                $original = $items[$idxItem]->itemPrice;

                $value = ($items[$idxItem]->itemPrice - $prices[$j]) * -1;

                // dump('apply to ' . $items[$idxItem]->id);
                $items[$idxItem]->offers()->attach($offer, ['value'=>$value, 'application_id' => $application, 'reset_data'=>['original_price'=>$original]]);

                $idxItem++; 
            }



        }


    }


    static function remove(Offer $offer, $target) {
        // dd($offer->pivot);
        $target->itemPrice = $offer->pivot->reset_data['original_price'];
        $target->save();
    }


}