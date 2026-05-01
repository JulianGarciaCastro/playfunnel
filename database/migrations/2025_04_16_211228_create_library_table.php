<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibraryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uri', 254)->nullable();
            $table->string('url', 254)->nullable();
            $table->string('name', 100);
            $table->string('description', 254)->nullable();
            $table->string('type', 20);
            $table->string('thumbnail', 254)->nullable();
            $table->integer('mediasize');
            $table->timestamp('createdate')->useCurrent();
            $table->bigInteger('createdby')->nullable();
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
        Schema::dropIfExists('library');
    }
}
