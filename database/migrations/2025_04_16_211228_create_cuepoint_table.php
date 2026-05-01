<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuepointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuepoint', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('projectid');
            $table->integer('libraryid');
            $table->integer('projectlibraryid');
            $table->integer('userid');
            $table->integer('position');
            $table->string('cuepointname', 50)->nullable();
            $table->decimal('time', 11, 4);
            $table->string('type', 20);
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
        Schema::dropIfExists('cuepoint');
    }
}
