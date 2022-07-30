<?php

use AscentCreative\Offer\Facades\Discountables;


Route::middleware('web')->group( function() {

  



    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('/admin')->middleware(['auth', 'can:administer'])->group(function() {


        Route::get('/offers/autocomplete/sellables', function() {

            // dd();

            $term = request()->term; 

            $items = collect([]);

            foreach(Discountables::getRegistry() as $cls) {
                $items = $items->concat($cls::autocomplete($term)->get());
            }

            $items = collect($items)->transform( function($item) {
                $item->label = $item->sellable_label;
                return [
                    'label' => $item->sellable_label,
                    'type' => get_class($item),
                    'id' => $item->id
                ];
            });

            return $items;
        
        })->name('offers.autocomplete.sellables');
    

        Route::get('/offers/{offer}/delete', [\AscentCreative\Offer\Controllers\Admin\OfferController::class, 'delete']);
        Route::resource('/offers', \AscentCreative\Offer\Controllers\Admin\OfferController::class, ['as'=>'admin']);

        
    });



});


