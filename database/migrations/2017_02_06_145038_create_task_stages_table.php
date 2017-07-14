<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\TaskStage;

class CreateTaskStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_stages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $data = [
            ['id' => 1, 'name' => 'Первичный контакт'],
            ['id' => 2, 'name' => 'Переговоры'],
            ['id' => 3, 'name' => 'Принятие решения'],
            ['id' => 4, 'name' => 'Успешная сделка'],
            ['id' => 5, 'name' => 'Не успешная сделка'],
        ];
        foreach ($data as $item) {
            $stage = new TaskStage();
            $stage->unguard();
            $stage->create($item);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('task_stages');
    }
}
