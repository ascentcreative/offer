<?php

namespace AscentCreative\Offer\Controllers\Admin;

use AscentCreative\CMS\Controllers\AdminBaseController;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

use AscentCreative\CMS\Admin\UI\Index\Column;

class OfferController extends AdminBaseController
{

    static $modelClass = 'AscentCreative\Offer\Models\Offer';
    // static $bladePath = "checkout::admin.orders";
    static $formClass = 'AscentCreative\Offer\Forms\Admin\Offer';

  
    public function __construct() {
        parent::__construct();
    }

    public function rules($request, $model=null) {

       return [
            'title' => 'required',
        ]; 

    }

    public function getColumns() : array {

        return [

            Column::make('Offer')
                ->valueProperty('alias')
                ->isLink(true),

            Column::make('Rule')
                ->valueProperty('rule_class'),

            

        ];

    }

}