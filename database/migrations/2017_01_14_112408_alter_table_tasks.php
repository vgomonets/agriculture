<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `close_condition` `task_close_condition_id` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        DB::statement("ALTER TABLE `task_templates` CHANGE COLUMN `executor_role` `executor_role_id` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `executor` `executor_id` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        DB::statement("ALTER TABLE `task_templates` CHANGE COLUMN `creator` `creator_id` INT(10) UNSIGNED NULL DEFAULT NULL; ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `task_close_condition_id` `close_condition` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        DB::statement("ALTER TABLE `task_templates` CHANGE COLUMN `executor_role_id` `executor_role` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        DB::statement("ALTER TABLE `tasks` CHANGE COLUMN `executor_id` `executor` INT(10) UNSIGNED NULL DEFAULT NULL; ");
        DB::statement("ALTER TABLE `task_templates` CHANGE COLUMN `creator_id` `creator` INT(10) UNSIGNED NULL DEFAULT NULL; ");
    }
}
