<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebhookIntegrationProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('webhook_integration_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('webhook_integration_id');
            $table->unsignedBigInteger('project_id');
            $table->timestamps();

            $table->unique(['webhook_integration_id', 'project_id'], 'webhook_project_unique');
            $table->index('project_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('webhook_integration_projects');
    }
}
