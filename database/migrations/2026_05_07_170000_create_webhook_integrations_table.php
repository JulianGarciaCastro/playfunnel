<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebhookIntegrationsTable extends Migration
{
    public function up()
    {
        Schema::create('webhook_integrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name')->default('Webhook principal');
            $table->string('endpoint_url', 1000)->nullable();
            $table->string('secret', 255)->nullable();
            $table->boolean('active')->default(false);
            $table->json('triggers')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('webhook_integrations');
    }
}
