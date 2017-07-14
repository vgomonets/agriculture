<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'task_templates',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('group')->unsigned()->nullable();
                $table->integer('task_stage_id')->unsigned()->nullable();
                $table->string('title');
                $table->text('description')->nullable();
                $table->enum('priority', ['low', 'normal', 'high']);
                $table->integer('close_condition')->unsigned()->nullable();
                $table->integer('executor_role')->unsigned()->nullable();
                $table->boolean('contractor_required')->default(0);
                $table->integer('hour_limit')->nullable();
                $table->integer('day_limit')->unsigned()->nullable();
                $table->integer('creator')->unsigned();
                $table->integer('order')->unsigned()->nullable();

                $table->timestamps();

                $table->index('group');
                $table->index('creator');
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
        Schema::drop('task_templates');
    }
}
