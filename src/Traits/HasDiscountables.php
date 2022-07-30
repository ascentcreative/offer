<?php

namespace AscentCreative\Offer\Traits;

use AscentCreative\CMS\Traits\Extender;

use AscentCreative\CMS\Forms\Structure\Screenblock;
use AscentCreative\Forms\Fields\PivotList;

use Illuminate\Http\Request;

trait HasDiscountables {

    use Extender;

    public function initializeHasDiscountables() {
        $this->addCapturable('discountables');
    }

    public function saveDiscountables($data) {
        // dd($data);
           
            /** Sync the licence data: */
    
            // get the ids of the existing rows:
            $stored = $this->discountables->collect()->transform(function($item) { return $item->id; })->toArray();
    
            // store / update the incoming data
            $incoming = array();
    
            if(isset($data)) {
                foreach($data as $row) {
        
                    $lic = $this->discountables()->updateOrCreate(
                        ['id'=>$row['id']],
                        $row
                    );
    
                    // log the updated / saved IDs
                    $incoming[] = $lic->id;
                } 
            }
    
            // do an array_diff to find the IDs to delete (i.e. they weren't in the incoming data)
            $del = array_diff($stored, $incoming);
    
            if (count($del) > 0) {
                // remove the deleted rows
                    \AscentCreative\Offer\Models\Discountable::destroy($del);
            }
    
        
    }

    public function deleteDiscountables() {
        $this->discountables()->delete();
    }

   
    // public function adjustFormForContacts($form) {

    //     $form->children([
    //         Screenblock::make("contacts_block")
    //             ->children([
    //                 PivotList::make('contacts', 'Portal Accounts')
    //                         ->description('The contacts which this login can access in the Writers Portal')
    //                         ->labelField('name')
    //                         ->optionRoute(action(['App\Http\Controllers\Admin\ContactController', 'autocomplete']))
    //                         ->optionModel(\App\Models\Contact::class)
    //                         ->sortField('sort')
    //             ])
    //     ]);

    // }

}
