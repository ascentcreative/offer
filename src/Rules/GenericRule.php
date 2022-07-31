<?php
namespace AscentCreative\Offer\Rules;


class GenericRule extends Rule {

    static function apply(Offer $offer, $basket) {
       
        $cfg = (object) $offer->config;

        // check the trigger:
        $fire = false;
        if($cfg->trigger = 'always') {
            $fire = true;
        }
        // Other checks here....

        




    }


    static function remove(Offer $offer, $target) {
        // $target->itemPrice = $offer->pivot->reset_data['original_price'];
        // $target->save();
    }



}