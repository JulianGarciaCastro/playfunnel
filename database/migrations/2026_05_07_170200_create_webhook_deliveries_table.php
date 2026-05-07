<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebhookDeliveriesTable extends Migration
{
    public function up()
    {
        Schema::create('webhook_deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('webhook_integration_id');
            $table->string('trigger', 80);
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('endpoint_url', 1000);
            $table->unsignedSmallInteger('status_code')->nullable();
            $table->boolean('success')->default(false);
            $table->text('request_payload')->nullable();
            $table->text('response_body')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['webhook_integration_id', 'trigger']);
            $table->index('project_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('webhook_deliveries');
    }
}
