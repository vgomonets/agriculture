<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\TaskStatus;

class CreateTaskStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        $status = new TaskStatus();
        $status->name = 'new';
        $status->save();

        $status = new TaskStatus();
        $status->name = 'inProcess';
        $status->save();

        $status = new TaskStatus();
        $status->name = 'expired';
        $status->save();

        $status = new TaskStatus();
        $status->name = 'canceled';
        $status->save();

        $status = new TaskStatus();
        $status->name = 'finished';
        $status->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('task_statuses');
    }
}
