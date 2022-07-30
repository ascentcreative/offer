<?php

namespace AscentCreative\Offer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Routing\Router;
use AscentCreative\Offer\Providers\EventServiceProvider;

class OfferServiceProvider extends ServiceProvider
{
  public function register()
  {

    $this->app->register(EventServiceProvider::class);
    //

    $this->app->singleton('offer:discountables',function(){
        return new \AscentCreative\Offer\Registries\Discountables();
    });

    $this->app->bind('offer:offer_engine',function(){
        $cls = config('offer.offer_engine');
        return new $cls();
    });

    // Register the helpers php file which includes convenience functions:
    // require_once (__DIR__.'/helpers.php');
   
    $this->mergeConfigFrom(
        __DIR__.'/../config/offer.php', 'offer'
    );

    $this->registerSchemaMacros();

    
    

  }

  public function boot()
  {

    $this->loadViewsFrom(__DIR__.'/../resources/views', 'offer');

    $this->loadRoutesFrom(__DIR__.'/../routes/offer-web.php');

    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    $this->bootComponents();

    // $this->findDiscountables();


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



    public function registerSchemaMacros() {

        \Illuminate\Database\Schema\Blueprint::macro('discountable', function() {
            if(!Schema::hasColumn($this->table, 'offer_id')) {
                $this->integer("offer_id")->nullable()->before('created_at');
            }
            if(!Schema::hasColumn($this->table, 'offer_alias')) {
                $this->string("offer_alias")->nullable()->before('created_at');
            }
            if(!Schema::hasColumn($this->table, 'original_price')) {
                $this->float("original_price")->nullable()->before('created_at');
            }
            
        });

        \Illuminate\Database\Schema\Blueprint::macro('dropDiscountable', function() {
            if(Schema::hasColumn($this->table, 'offer_id')) {
                $this->dropColumn("offer_id");
            }
            if(Schema::hasColumn($this->table, 'offer_alias')) {
                $this->dropColumn("offer_alias");
            }
            if(Schema::hasColumn($this->table, 'original_price')) {
                $this->dropColumn("original_price");
            }
        });

    }






}