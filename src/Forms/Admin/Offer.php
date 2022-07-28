<?php
namespace AscentCreative\Offer\Forms\Admin;

use AscentCreative\CMS\Forms\Admin\BaseForm;
use AscentCreative\CMS\Forms\Structure\Screenblock;

use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\Options;
use AscentCreative\Forms\Structure\SubformLoader;

class Offer extends BaseForm {

    public function __construct($rule = null) {

        parent::__construct();

        $this->children([

            Screenblock::make('general')
                ->children([
                
                    Input::make('alias', 'Alias'),

                    // Class Selector (just a select, linked to the list of classes registered?)
                    Options::make('rule_class', 'Rule')
                        ->options([
                            'AscentCreative\Offer\Rules\BuyABCForY'=>'Buy ABC For £Y',
                            'AscentCreative\Offer\Rules\BuyXForY'=>'Buy X For £Y'
                        ]),


                    // Subform loader (linked to the above class field)
                    SubformLoader::make('sf_rule', 'rule_class', function($item) {
                        // resolve the subform to load.
                    }), 

                    

            ]),

        ]);

    }


}