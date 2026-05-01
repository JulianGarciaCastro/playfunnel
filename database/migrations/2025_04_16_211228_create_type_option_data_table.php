<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeOptionDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_option_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userid');
            $table->integer('projectid');
            $table->integer('projectlibraryid');
            $table->integer('libraryid');
            $table->integer('cuepointid');
            $table->integer('typeoptionid');
            $table->integer('position')->nullable();
            $table->string('name', 20)->nullable();
            $table->string('type', 20)->nullable();
            $table->string('goto', 254)->nullable();
            $table->string('options', 254)->nullable();
            $table->string('text', 500)->nullable();
            $table->string('image_yorn', 254)->nullable();
            $table->string('image_url', 254)->nullable();
            $table->string('class_options', 254)->nullable();
            $table->string('style_options', 254)->nullable();
            $table->string('title', 254)->nullable();
            $table->longText('content')->nullable();
            $table->string('uuid', 128)->nullable();
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
        Schema::dropIfExists('type_option_data');
    }
}
