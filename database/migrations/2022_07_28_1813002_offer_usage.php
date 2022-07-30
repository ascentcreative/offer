<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OfferUsage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('offer_usage', function(Blueprint $table) {
            $table->id();
            $table->integer('offer_id')->index();
            $table->string('target_type')->index();
            $table->integer('target_id')->index();
            $table->string('application_id')->nullable()->index();
            $table->float('value');
            $table->text('reset_data')->nullable();
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
        Schema::drop('offer_usage');
    
    }
}
