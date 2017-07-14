<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\BusinessAction;

class CreateBusinessActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('action')->nullable();
            $table->timestamps();
        });
        
        //Шаги бизнес процессов
        BusinessAction::insert([
            ['name' => 'Добавление клиента', 'action' => 'clientAdd'],
            ['name' => 'Подтверждение контактов клиента', 'action' => 'confirmationContacts'],
            ['name' => 'Знакомство с клиентом', 'action' => 'acquaintance'],
            ['name' => 'Выявление потребности', 'action' => 'needs'],
            ['name' => 'Подготовка коммерческого предложения', 'action' => 'proposal'],
            ['name' => 'Оформление заказа', 'action' => 'order'],
            ['name' => 'Выставление счета', 'action' => 'invoice'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('business_actions');
    }
}
