<?php
namespace AscentCreative\Offer\Forms\Admin;

use AscentCreative\CMS\Forms\Admin\BaseForm;
use AscentCreative\CMS\Forms\Structure\Screenblock;

use AscentCreative\Forms\Fields\Input;
use AscentCreative\Forms\Fields\MorphPivot;
use AscentCreative\Forms\Fields\Options;
use AscentCreative\Forms\Structure\SubformLoader;
use AscentCreative\Forms\Structure\HTML;

class Offer extends BaseForm {

    public function __construct($rule = null) {

        parent::__construct();

        $this->children([

            Screenblock::make('general')
                ->children([

                    HTML::make('<div class="flex flex-align-start">', '</div>')
                        ->children([
                            HTML::make('<div style="flex-grow: 1">', '</div>')
                                ->children([

                                    Input::make('alias', 'Alias'),

                                    Input::make('code', 'Code')
                                        ->description('leave blank to automatically apply when the relevant products are added to the basket.'),

                                    // Class Selector (just a select, linked to the list of classes registered?)
                                    Options::make('rule_class', 'Rule')
                                        ->options([
                                            'AscentCreative\Offer\Rules\BuyABCForY'=>'Buy ABC For £Y',
                                            'AscentCreative\Offer\Rules\BuyXForY'=>'Buy X For £Y',
                                            'AscentCreative\Offer\Rules\PercentDiscount'=>'Discount (%)'
                                        ]),
                
                
                                    // Subform loader (linked to the above class field)
                                    SubformLoader::make('sf_rule', 'rule_class', [
                                        'AscentCreative\Offer\Rules\BuyABCForY' => 'AscentCreative\Offer\Forms\Admin\Rules\BuyABCForY',
                                        'AscentCreative\Offer\Rules\BuyXForY' => 'AscentCreative\Offer\Forms\Admin\Rules\BuyXForY',
                                        'AscentCreative\Offer\Rules\PercentDiscount'=>'AscentCreative\Offer\Forms\Admin\Rules\PercentDiscount'
                                    ]), 

                                ]),
                            // HTML::make('<div class="">', '</div>')
                                // ->children([
                                    \AscentCreative\CMS\Forms\Subform\Publishable::make(''),
                                // ])
                        ]),
                
                   

                    

            ]),

            Screenblock::make('items')
                ->children([

                    MorphPivot::make('discountables', 'Items')
                        ->morph('discountable')
                        ->bladepath('offer::morphpivot')
                        ->optionRoute(route('sellables.autocomplete'))
                        ->optionModel('AscentCreative\Offer\Models\Discountable')
                        ->labelField('label'),

                ]),

        ]);

    }


}