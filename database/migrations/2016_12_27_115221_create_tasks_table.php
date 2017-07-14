<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'tasks',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('group')->unsigned()->nullable();
                $table->integer('task_stage_id')->unsigned()->nullable();
                $table->integer('chain')->unsigned()->nullable();
                $table->integer('template_id')->unsigned()->nullable();
                $table->string('title');
                $table->text('description')->nullable();
                $table->enum('priority', ['low', 'normal', 'high']);
                $table->integer('close_condition')->unsigned()->nullable();
                $table->integer('status')->unsigned();
                $table->integer('executor_role')->unsigned()->nullable();
                $table->integer('executor')->unsigned()->nullable();
                $table->integer('contractor')->unsigned()->nullable();
                $table->integer('task_order')->unsigned()->nullable();
                $table->dateTime('execution_date');
                $table->dateTime('taking_date')->nullable();
                $table->dateTime('close_date')->nullable();
                $table->integer('creator')->unsigned();

                $table->timestamps();

                $table->index('creator');
                $table->index('executor');
                $table->index('contractor');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasks');
    }
}
