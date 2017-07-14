<?php

use App\Models\TaskStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTaskStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_statuses', function (Blueprint $table) {
            $table->string('color')->nullable();
        });
        $status = TaskStatus::where(['name' => 'new'])->first();
            $status->color = '';
            $status->save();
        $status = TaskStatus::where(['name' => 'inProcess'])->first();
            $status->color = 'green';
            $status->save();
        $status = TaskStatus::where(['name' => 'expired'])->first();
            $status->color = 'coral';
            $status->save();
        $status = TaskStatus::where(['name' => 'canceled'])->first();
            $status->color = 'red';
            $status->save();
        $status = TaskStatus::where(['name' => 'finished'])->first();
            $status->color = 'orange';
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
            $table->dropColumn('color');
        });
    }
}
