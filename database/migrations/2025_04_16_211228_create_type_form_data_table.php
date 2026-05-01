<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeFormDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_form_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('projectid');
            $table->integer('libraryid');
            $table->integer('cuepointid');
            $table->integer('typeformid');
            $table->string('name', 100)->nullable();
            $table->string('email', 254)->nullable();
            $table->string('phone', 254)->nullable();
            $table->string('title', 254)->nullable();
            $table->longText('comments')->nullable();
            $table->timestamp('birthday')->useCurrentOnUpdate()->useCurrent();
            $table->string('postalcode', 25)->nullable();
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
        Schema::dropIfExists('type_form_data');
    }
}
