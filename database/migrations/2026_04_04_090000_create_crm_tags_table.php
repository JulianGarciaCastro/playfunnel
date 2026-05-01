<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('crm_tags')) {
            return;
        }

        Schema::create('crm_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userid');
            $table->string('name', 120);
            $table->string('slug', 120);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['userid', 'name'], 'crm_tags_userid_name_unique');
            $table->unique(['userid', 'slug'], 'crm_tags_userid_slug_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crm_tags');
    }
}

