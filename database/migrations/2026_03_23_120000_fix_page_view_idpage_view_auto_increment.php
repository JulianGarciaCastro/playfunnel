<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixPageViewIdpageViewAutoIncrement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('page_view')) {
            return;
        }

        if (!Schema::hasColumn('page_view', 'projectid')) {
            Schema::table('page_view', function (Blueprint $table) {
                $table->bigInteger('projectid')->nullable()->after('type');
            });
        }

        $primaryKey = DB::select("SHOW KEYS FROM `page_view` WHERE Key_name = 'PRIMARY'");
        if (empty($primaryKey)) {
            DB::statement('ALTER TABLE `page_view` ADD PRIMARY KEY (`idpage_view`)');
        }

        $column = DB::selectOne("
            SELECT COLUMN_TYPE, EXTRA
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'page_view'
              AND COLUMN_NAME = 'idpage_view'
        ");

        if ($column && stripos($column->EXTRA, 'auto_increment') === false) {
            DB::statement("ALTER TABLE `page_view` MODIFY `idpage_view` {$column->COLUMN_TYPE} NOT NULL AUTO_INCREMENT");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Intentionally left empty to avoid destructive rollback on a primary key fix.
    }
}
