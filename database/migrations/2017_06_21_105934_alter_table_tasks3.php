<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTasks3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function(Blueprint $table)
        {
            $table->dropColumn('task_close_condition_id');
            $table->float('latitude')->nullable()->unsigned();
            $table->float('longitude')->nullable()->unsigned();
        });
        Schema::table('task_templates', function(Blueprint $table)
        {
            $table->dropColumn('task_close_condition_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function(Blueprint $table)
        {
            $table->integer('task_close_condition_id')->unsigned()->nullable();
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
        Schema::table('task_templates', function(Blueprint $table)
        {
            $table->integer('task_close_condition_id')->unsigned()->nullable();
        });
    }
}
