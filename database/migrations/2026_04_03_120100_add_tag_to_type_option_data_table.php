<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTagToTypeOptionDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_option_data', function (Blueprint $table) {
            if (!Schema::hasColumn('type_option_data', 'tag')) {
                $table->string('tag', 120)->nullable()->after('options');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_option_data', function (Blueprint $table) {
            if (Schema::hasColumn('type_option_data', 'tag')) {
                $table->dropColumn('tag');
            }
        });
    }
}

