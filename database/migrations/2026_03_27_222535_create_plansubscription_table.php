<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plansubscription', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('plantypeid')->nullable();
            $table->integer('userid')->nullable();
            $table->dateTime('startdate')->nullable();
            $table->dateTime('enddate')->nullable();
            $table->dateTime('enterdate')->useCurrent();
            $table->dateTime('canceldate')->nullable();
            $table->string('description', 254)->nullable();
            $table->boolean('active')->nullable();
            $table->integer('enterby')->nullable();
            $table->string('invoicenum', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plansubscription');
    }
}
