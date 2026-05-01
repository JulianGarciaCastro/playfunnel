<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_custom_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userid');
            $table->string('name', 120);
            $table->string('slug', 120);
            $table->string('type', 40)->default('text');
            $table->longText('options')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['userid', 'slug'], 'crm_custom_fields_userid_slug_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crm_custom_fields');
    }
}
