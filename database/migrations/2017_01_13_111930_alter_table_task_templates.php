<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTaskTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `task_templates` CHANGE COLUMN `group` `group_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `id`; ");
        DB::statement("ALTER TABLE `task_templates` CHANGE COLUMN `close_condition` `task_close_condition_id` INT(10) UNSIGNED NULL DEFAULT NULL; ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `task_templates` CHANGE COLUMN `group_id` `group` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `id`; ");
        DB::statement("ALTER TABLE `task_templates` CHANGE COLUMN `task_close_condition_id` `close_condition` INT(10) UNSIGNED NULL DEFAULT NULL; ");
    }
}
