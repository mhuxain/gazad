<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGazetteAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gazette_ads', function (Blueprint $table) {
            $table->id();   
            $table->integer('_id')->nullable();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('office')->nullable();
            $table->string('due')->nullable();
            $table->string('link')->nullable();
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
        Schema::dropIfExists('gazette_ads');
    }
}
