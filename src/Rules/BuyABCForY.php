<?php

namespace AscentCreative\Offer\Rules;

use AscentCreative\Offer\Rules\AbstractRule as Rule;
use AscentCreative\Offer\Models\Offer;

class BuyABCForY extends Rule {

    static function apply(Offer $offer, $basket) {
       
        $cfg = json_decode($offer->config);

        $items = $offer->applicableItems($basket);

        $grouped = $items->groupBy('morph_key');

        $itemKeys = $offer->discountables->transform(function($item) { return morphKey($item, 'discountable'); });

        $iterations = 9999;
        foreach($itemKeys as $itemKey) {
            $iterations = min($iterations, count($grouped[$itemKey] ?? []));
        }


        

        // iterate the max number of times:
        // foreach($)

        // for each iteration
        $idxItem = 0;
        for($i = 0; $i < $iterations; $i++) {

            // get one of each item:
            $oneOfEach=[];
            foreach($itemKeys as $itemKey) {
                $oneOfEach[] = $grouped[$itemKey][$i];
            }
            $oneOfEach = collect($oneOfEach);

            $splitPrices = \AscentCreative\CMS\Util\SplitAndRound::process($cfg->price, $oneOfEach->pluck('itemPrice')->toArray());

            for($iEach = 0; $iEach < count($oneOfEach); $iEach++) {
                $oneOfEach[$iEach]->itemPrice = $splitPrices[$iEach];
                $oneOfEach[$iEach]->offer_id = $offer->id;
                $oneOfEach[$iEach]->offer_alias = $offer->alias;
                $oneOfEach[$iEach]->save();
            }



            // splitAndRound the price across the items:

            // // apply the offer to the specified number of items
            // for($j = 0; $j < $cfg->quantity_required; $j++) {
            //     $items[$idxItem]->itemPrice = $cfg->price_each;
            //     $items[$idxItem]->offer_id = $offer->id;
            //     $items[$idxItem]->offer_alias = $offer->alias;
            //     $items[$idxItem]->save();
            //     $idxItem++;
            // }

        }


    }

}