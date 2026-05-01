<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeBrowseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_browse', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('projectid');
            $table->integer('libraryid');
            $table->integer('userid');
            $table->integer('cuepointid');
            $table->string('type', 20)->nullable();
            $table->string('goto', 254)->nullable();
            $table->string('options', 254)->nullable();
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
        Schema::dropIfExists('type_browse');
    }
}
