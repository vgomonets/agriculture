<?php

use App\Models\OrderPayType;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPayTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_pay_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $orderPayType = new OrderPayType();
        $orderPayType->name = 'Предоплата';
        $orderPayType->save();
        $orderPayType = new OrderPayType();
        $orderPayType->name = 'Кредитный';
        $orderPayType->save();
        $orderPayType = new OrderPayType();
        $orderPayType->name = 'Акционный';
        $orderPayType->save();
        $orderPayType = new OrderPayType();
        $orderPayType->name = 'Оплата по факту';
        $orderPayType->save();
        $orderPayType = new OrderPayType();
        $orderPayType->name = 'Частичная оплата';
        $orderPayType->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_pay_types');
    }
}
