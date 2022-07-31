<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OfferTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // the products
        Schema::create('offer_offers', function(Blueprint $table) {
            $table->id();

            $table->string('rule_class')->index();
            $table->string('alias')->nullable();
            $table->text('description')->nullable();
            $table->text('config');
            $table->timestamp('start_date')->index()->nullable();
            $table->timestamp('end_date')->index()->nullable();
            $table->tinyInteger('in_conjunction')->index();
            $table->integer('processing_order')->index();
            $table->tinyInteger('is_enabled')->index();
            $table->string('code')->nullable()->index();

            $table->timestamps();
        });

        // attributes for products
        Schema::create('offer_sellables', function(Blueprint $table) {
            $table->id();

            $table->integer('offer_id')->index();
            $table->string('sellable_type')->index();
            $table->integer('sellable_id')->index();

            $table->timestamps();
        });


        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('offer_offers');
        Schema::drop('offer_sellables');
      
    
    }
}
