<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('username', 20)->nullable()->unique();
            $table->string('lastname', 50)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('country', 99)->nullable();
            $table->string('city', 99)->nullable();
            $table->string('postalcode', 20)->nullable();
            $table->string('address', 99)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('status', 10)->default('INACTIVE');
            $table->string('grpname', 10)->default('NONE');
            $table->integer('attempts')->default(0);
            $table->string('profile_img', 254)->default('images/SVG/user-solid.svg');
            $table->integer('max_interactinos_history')->default(1);
            $table->string('customernum', 45)->nullable();
            $table->string('google_id')->nullable();
            $table->string('google_token')->nullable();
            $table->string('google_refresh_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
