<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTagsToCrmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('crm', 'tags')) {
            Schema::table('crm', function (Blueprint $table) {
                $table->string('tags', 500)->nullable()->after('country');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('crm', 'tags')) {
            Schema::table('crm', function (Blueprint $table) {
                $table->dropColumn('tags');
            });
        }
    }
}

