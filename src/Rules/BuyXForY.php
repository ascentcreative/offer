<?php

namespace AscentCreative\Offer\Rules;

use AscentCreative\Offer\Rules\AbstractRule as Rule;
use AscentCreative\Offer\Models\Offer;

class BuyXForY extends Rule {

    static function apply(Offer $offer, $basket) {
       
        // $cfg = json_decode($offer->config);
        $cfg = (object) $offer->config;

        $items = $offer->applicableItems($basket);

        // dump($items);

        // return;

        // iterate the max number of times:
        $iterations = floor($items->count() / $cfg->quantity_required);

        // dump('iterations:', $iterations);
// return;

        $itemKeys = $items->keys();
        // dump($itemKeys);

        // for each iteration
        $idxItem = 0;
        for($i = 0; $i < $iterations; $i++) {

            $application = uniqid();

            $prices = \AscentCreative\CMS\Util\SplitAndRound::processEqually($cfg->total, $cfg->quantity_required);

            // dump($prices);
            // return;

            // apply the offer to the specified number of items
            for($j = 0; $j < $cfg->quantity_required; $j++) {

                $basket->_items[$itemKeys[$idxItem]]->itemPrice = $prices[$j];

                $basket->_items[$itemKeys[$idxItem]]->offer_id = $offer->id;

                // $original = $items[$idxItem]->itemPrice;

                // $value = ($items[$idxItem]->itemPrice - $prices[$j]) * -1;

                // dump('apply to ' . $items[$idxItem]->id);
                // $items[$idxItem]->offers()->attach($offer, ['value'=>$value, 'application_id' => $application, 'reset_data'=>['original_price'=>$original]]);

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