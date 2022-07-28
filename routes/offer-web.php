<?php


Route::middleware('web')->group( function() {

  



    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('/admin')->middleware(['auth', 'can:administer'])->group(function() {

        Route::get('/offers/{offer}/delete', [\AscentCreative\Offer\Controllers\Admin\OfferController::class, 'delete']);
        Route::resource('/offers', \AscentCreative\Offer\Controllers\Admin\OfferController::class, ['as'=>'admin']);
    
    });



});


