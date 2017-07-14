<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationTaskCloseConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_tasks_task_close_conditions', function (Blueprint $table) {
            $table->integer('task_id');
            $table->integer('task_close_condition_id');
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['task_id', 'task_close_condition_id'], 'relation_close_condition');
        });
    }


    public function down()
    {
        Schema::drop('relation_tasks_task_close_conditions');
    }
}
