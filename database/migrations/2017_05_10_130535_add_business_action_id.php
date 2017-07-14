<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBusinessActionId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_templates', function (Blueprint $table) {
            $table->integer('business_action_id')->unsigned()->nullable();
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('business_action_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_templates', function(Blueprint $table)
        {
            $table->dropColumn('business_action_id');
        });
        Schema::table('tasks', function(Blueprint $table)
        {
            $table->dropColumn('business_action_id');
        });
    }
}
