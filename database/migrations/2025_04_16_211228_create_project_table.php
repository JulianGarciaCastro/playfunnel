<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('user_id');
            $table->string('name', 30);
            $table->string('aspect', 10)->default('d-main');
            $table->integer('publish_library_img')->nullable();
            $table->text('publish_div')->nullable();
            $table->timestamp('creation_date')->useCurrentOnUpdate()->useCurrent();
            $table->integer('project_status_id')->default(1);
            $table->longText('landing_page')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project');
    }
}
