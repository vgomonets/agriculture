<?php

use App\Models\TaskStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTaskStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_statuses', function (Blueprint $table) {
            $table->string('title')->after('name');
        });
        $status = TaskStatus::where(['name' => 'new'])->first();
        $status->title = 'Новый';
        $status->save();
        $status = TaskStatus::where(['name' => 'inProcess'])->first();
        $status->title = 'В работе';
        $status->save();
        $status = TaskStatus::where(['name' => 'expired'])->first();
        $status->title = 'Просрочен';
        $status->save();
        $status = TaskStatus::where(['name' => 'canceled'])->first();
        $status->title = 'Отменен';
        $status->save();
        $status = TaskStatus::where(['name' => 'finished'])->first();
        $status->title = 'Завершен';
        $status->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_statuses', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
}
