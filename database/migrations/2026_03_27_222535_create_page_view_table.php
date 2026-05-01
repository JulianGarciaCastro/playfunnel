<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_view', function (Blueprint $table) {
            $table->bigInteger('idpage_view', true);
            $table->string('page', 50);
            $table->dateTime('date')->useCurrent();
            $table->string('source', 50)->nullable();
            $table->string('type', 50)->nullable();
            $table->bigInteger('projectid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_view');
    }
}
