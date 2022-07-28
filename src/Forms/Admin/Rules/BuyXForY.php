<?php
namespace AscentCreative\Offer\Forms\Admin\Rules;

use AscentCreative\Forms\Structure\Subform;
use AscentCreative\Forms\Fields\Input;

class BuyXForY extends Subform {

    public function initialise() {

        return $this->children([
            Input::make('config[quantity_required]', 'Quantity')
                ->required(true)
                ->messages(['required'=>'Please give the quantity that must be bought.']),
            Input::make('config[total]', 'Total Price')
                ->required(true)
                ->messages(['required'=>'Please give the total price when the above quantity is bought.']),
        ]);

    }


}