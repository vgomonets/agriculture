<?php

use App\Models\OrderStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $order = new OrderStatus();
            $order->name = 'Черновик';
            $order->save();
        $order = new OrderStatus();
            $order->name = 'Передан на согласование';
            $order->save();
        $order = new OrderStatus();
            $order->name = 'Передан на обработку логисту';
            $order->save();
        $order = new OrderStatus();
            $order->name = 'Принят на обработку';
            $order->save();
        $order = new OrderStatus();
            $order->name = 'Подтверждение логиста';
            $order->save();
        $order = new OrderStatus();
            $order->name = 'Выставлен счет';
            $order->save();
        $order = new OrderStatus();
            $order->name = 'Готовится к отгрузке';
            $order->save();
        $order = new OrderStatus();
            $order->name = 'Отправлен';
            $order->save();
        $order = new OrderStatus();
            $order->name = 'Доставлен';
            $order->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_statuses');
    }
}
