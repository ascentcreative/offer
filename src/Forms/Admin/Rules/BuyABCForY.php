<?php
namespace AscentCreative\Offer\Forms\Admin\Rules;

use AscentCreative\Forms\Structure\Subform;
use AscentCreative\Forms\Fields\Input;

class BuyABCForY extends Subform {

    public function initialise() {

        return $this->children([
            Input::make('config[price]', 'Price'),
        ]);

    }


}