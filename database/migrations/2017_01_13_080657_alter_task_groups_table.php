<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTaskGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_groups', function (Blueprint $table) {
            $table->string('name');
            $table->integer('tasks_count')->unsigned();
        });
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `group` `group_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `id`; ");
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `status` `task_status_id` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `executor_role` `executor_role_id` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `contractor` `contractor_id` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `creator` `creator_id` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        exec("mysql -u ".env('DB_USERNAME', 'forge')." -p".env('DB_PASSWORD', '')." ".env('DB_DATABASE', 'forge')." < " . database_path(). '/dump/2017_01_13_080657_alter_task_groups_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_groups', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('tasks_count');
        });
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `group_id` `group` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `id`; ");
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `task_status_id` `status` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `executor_role_id` `executor_role` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `contractor_id` `contractor` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `creator_id` `creator` INT(10) UNSIGNED NULL DEFAULT NULL; ");
    }
}
