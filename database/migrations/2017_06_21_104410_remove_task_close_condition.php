<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\TaskCloseCondition;

class RemoveTaskCloseCondition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        TaskCloseCondition::where('id', '=', 3)
            ->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
