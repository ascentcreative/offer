<?php

namespace AscentCreative\Offer\Rules;

use AscentCreative\Offer\Rules\AbstractRule as Rule;
use AscentCreative\Offer\Models\Offer;

class BuyABCForY extends Rule {

    static function apply(Offer $offer, $basket) {
       
        // $cfg = json_decode($offer->config);
        $cfg = (object) $offer->config;

        $items = $offer->applicableItems($basket);

        $grouped = $items->groupBy('morph_key');

        $itemKeys = $offer->sellables->transform(function($item) { return morphKey($item, 'sellable'); });

        $iterations = 9999;
        foreach($itemKeys as $itemKey) {
            $iterations = min($iterations, count($grouped[$itemKey] ?? []));
        }

        // iterate the max number of times:
        // foreach($)

        // for each iteration
        $idxItem = 0;
        for($i = 0; $i < $iterations; $i++) {

            $application = uniqid();

            // get one of each item:
            $oneOfEach=[];
            foreach($itemKeys as $itemKey) {
                $oneOfEach[] = $grouped[$itemKey][$i];
            }
            $oneOfEach = collect($oneOfEach);

            $splitPrices = \AscentCreative\CMS\Util\SplitAndRound::process($cfg->price, $oneOfEach->pluck('itemPrice')->toArray());

            for($iEach = 0; $iEach < count($oneOfEach); $iEach++) {

                // store the original price
                $original = $oneOfEach[$iEach]->itemPrice;

                $value = ($oneOfEach[$iEach]->itemPrice - $splitPrices[$iEach]) * -1;
               
                // $oneOfEach[$iEach]->itemPrice = $splitPrices[$iEach];
                // // $oneOfEach[$iEach]->offer_id = $offer->id;
                // // $oneOfEach[$iEach]->offer_alias = $offer->alias;
                // $oneOfEach[$iEach]->save();

                $oneOfEach[$iEach]->offers()->attach($offer, ['value'=>$value, 'application_id'=>$application, 'reset_data'=>['original_price'=>$original]]);

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

    static function remove(Offer $offer, $target) {
        // dd($offer->pivot);
        $target->itemPrice = $offer->pivot->reset_data['original_price'];
        $target->save();
    }

 }