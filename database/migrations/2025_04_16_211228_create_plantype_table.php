<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantype', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 45)->nullable();
            $table->decimal('size', 10)->nullable();
            $table->decimal('price', 6)->nullable();
            $table->integer('duration')->nullable();
            $table->string('interval', 45)->nullable();
            $table->boolean('active')->nullable();
            $table->dateTime('enterdate')->nullable()->useCurrent();
            $table->dateTime('changedate')->nullable()->useCurrent();
            $table->integer('enterby')->nullable();
            $table->boolean('default')->default(false);
            $table->string('productnum', 45)->nullable();
            $table->string('pricenum', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plantype');
    }
}
