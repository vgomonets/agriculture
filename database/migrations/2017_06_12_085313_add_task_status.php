<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\TaskStatus;

class AddTaskStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $date = date('Y-m-d H:i:s');
        
        TaskStatus::insert([
            'id' => '6',
            'name' => 'complete',
            'title' => 'Задача выполнена',
            'color' => 'green',
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        TaskStatus::where(['id' => 6])
            ->delete();
    }
}
