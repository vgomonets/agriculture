<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\TaskCloseCondition;

class CreateTaskCloseConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'task_close_conditions',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique();
                $table->string('title')->nullable();
                $table->string('type')->nullable();
                $table->timestamps();
            }
        );

        $condition = new TaskCloseCondition();
        $condition->name = 'chekin';
        $condition->title = 'Отметиться на месте';
        $condition->save();

        $condition = new TaskCloseCondition();
        $condition->name = 'file upload';
        $condition->title = 'Загрузка файла';
        $condition->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('task_close_conditions');
    }
}
