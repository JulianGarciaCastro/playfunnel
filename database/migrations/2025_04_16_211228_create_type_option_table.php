<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_option', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('projectid');
            $table->integer('libraryid');
            $table->integer('userid');
            $table->integer('cuepointid');
            $table->string('type', 20)->nullable();
            $table->integer('options')->nullable();
            $table->integer('position')->nullable();
            $table->string('text', 500)->nullable();
            $table->string('image', 254)->nullable();
            $table->longText('content')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_option');
    }
}
