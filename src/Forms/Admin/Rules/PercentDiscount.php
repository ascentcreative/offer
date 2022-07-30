<?php
namespace AscentCreative\Offer\Forms\Admin\Rules;

use AscentCreative\Forms\Structure\Subform;
use AscentCreative\Forms\Fields\Options;
use AscentCreative\Forms\Fields\Input;

class PercentDiscount extends Subform {

    public function initialise() {

        return $this->children([
            Options::make('config[against]', 'Against')
                ->required(true)
                ->options([
                    'basket'=>'Whole Basket',
                    'items'=>'Specified Items'
                ]),
            Input::make('config[percentage]', 'Discount')
                ->postelement('%')
                ->required(true)
                ->messages(['required'=>'Please give the total price when the above quantity is bought.']),
        ]);

    }


}