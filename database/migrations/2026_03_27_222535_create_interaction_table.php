<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interaction', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('sessionid');
            $table->integer('projectid');
            $table->bigInteger('cuepointid')->nullable();
            $table->string('cuepointname', 45)->nullable();
            $table->bigInteger('cuepointoptionid')->nullable();
            $table->string('cuepointoptionname', 45)->nullable();
            $table->integer('interactiontype')->default(0)->comment('0: Interacción inicial
1: Interacción final (completado)
2: Otro tipo de interacción');
            $table->string('loc_ip', 50)->nullable();
            $table->string('loc_city', 30)->nullable();
            $table->string('loc_state', 30)->nullable();
            $table->string('loc_country', 30)->nullable();
            $table->string('loc_country_code', 2)->nullable();
            $table->string('loc_continent', 30)->nullable();
            $table->string('loc_continent_code', 5)->nullable();
            $table->string('device', 10)->default('dv-desktop');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interaction');
    }
}
