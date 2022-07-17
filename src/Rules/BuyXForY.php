<?php

namespace AscentCreative\Offer\Rules;

use AscentCreative\Offer\Rules\AbstractRule as Rule;
use AscentCreative\Offer\Models\Offer;

class BuyXForY extends Rule {

    static function apply(Offer $offer, $basket) {
       
        $cfg = json_decode($offer->config);

        $items = $offer->applicableItems($basket);

        // iterate the max number of times:
        $iterations = floor($items->count() / $cfg->quantity_required);

        // for each iteration
        $idxItem = 0;
        for($i = 0; $i < $iterations; $i++) {

            $prices = \AscentCreative\CMS\Util\SplitAndRound::processEqually($cfg->total, $cfg->quantity_required);

            // apply the offer to the specified number of items
            for($j = 0; $j < $cfg->quantity_required; $j++) {
                $items[$idxItem]->itemPrice = $prices[$j];
                $items[$idxItem]->offer_id = $offer->id;
                $items[$idxItem]->offer_alias = $offer->alias;
                $items[$idxItem]->save();
                $idxItem++;
            }

        }


    }

}