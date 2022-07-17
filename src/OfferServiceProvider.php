<?php

namespace AscentCreative\Offer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\Router;

class OfferServiceProvider extends ServiceProvider
{
  public function register()
  {
    //

    // Register the helpers php file which includes convenience functions:
    // require_once (__DIR__.'/helpers.php');
   
    $this->mergeConfigFrom(
        __DIR__.'/../config/offer.php', 'offer'
    );

  }

  public function boot()
  {

    $this->loadViewsFrom(__DIR__.'/../resources/views', 'help');

    $this->loadRoutesFrom(__DIR__.'/../routes/offer-web.php');

    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    $this->bootComponents();


  }

  

  // register the components
  public function bootComponents() {


  }




  

    public function bootPublishes() {

      $this->publishes([
        __DIR__.'/Assets' => public_path('vendor/ascentcreative/offer'),
    
      ], 'public');

      $this->publishes([
        __DIR__.'/config/offer.php' => config_path('offer.php'),
      ]);

    }



}