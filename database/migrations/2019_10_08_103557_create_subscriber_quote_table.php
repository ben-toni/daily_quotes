<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriberQuoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriber_quote', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('subscriber_id')->unsigned();
            $table->bigInteger('quote_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('subscriber_quote', function (Blueprint $table) {
            $table->foreign('subscriber_id')->references('id')->on('subscribers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('quote_id')->references('id')->on('quotes')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriber_quote');
    }
}
