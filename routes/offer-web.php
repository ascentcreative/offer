<?php


Route::middleware('web')->group( function() {

  

});




/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'can:administer'])->group(function() {

   
});

