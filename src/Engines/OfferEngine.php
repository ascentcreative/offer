<?php
namespace AscentCreative\Offer\Engines;

use AscentCreative\Offer\Models\Offer;
use Illuminate\Support\Facades\DB;

/**
 * Does the work of applying current offers to the basket (need a name to ambiguate it...)
 */
class OfferEngine {

    static function process($basket) {

        //reset all the 'real' Prices;
        // - first, make sure any newly added items have their original price stored:
        $basket->items()->whereNull('original_price')->update(['original_price' => DB::Raw('itemPrice')]);

        // - next, reset all the item prices to the original price and remove offer references:
        $basket->items()->update([
                'itemPrice' => DB::Raw('original_price'),
                'offer_id'=>null,
                'offer_alias'=>null
            ]); ///resetPurchasePrices();

        // get the active offers from the database
        $offers = Offer::live()->get();

        // also need to factor in offers attached via a coupon code. $basket->getOfferCodes()?
        // - think I'd like to store the offers as linked models so we keep a record in the DB. 
        // - they'll be activated by a code, and if matched, added as a related model

        // once we have all the offers in play, process them:
       
        foreach($offers as $offer) {
            // dump($offer);

            $cls = $offer->rule_class;
            $rule = $cls::apply($offer, $basket);

        }

        // dd($offers);

		

    }

}